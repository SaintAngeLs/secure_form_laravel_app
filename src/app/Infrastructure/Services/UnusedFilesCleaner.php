<?php

namespace App\Infrastructure\Services;

use App\Application\Services\Infrastructure\IMessageBroker;
use App\Infrastructure\Persistence\Models\File;
use App\Infrastructure\Persistence\Models\FormEntry;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UnusedFilesCleaner
{
    private IMessageBroker $messageBroker;
    private const TOPIC_NAME = 'form-entries';
    private const UNUSED_FILE_THRESHOLD_MINUTES = 5;
    private const STORAGE_DISK = 'public';

    public function __construct(IMessageBroker $messageBroker)
    {
        $this->messageBroker = $messageBroker;
    }

    public function handleUnusedFiles(): void
    {
        Log::info(message: "Subscribing to Kafka topic: " . self::TOPIC_NAME);

        $this->messageBroker->subscribeAsync(self::TOPIC_NAME, function ($message) {
            Log::info("Event received from topic: " . self::TOPIC_NAME, ['message' => $message]);

            try {
                $this->processEvent($message);
            } catch (\Exception $e) {
                Log::error("Error processing event.", ['message' => $message, 'exception' => $e->getMessage()]);
            }
        });
    }

    private function processEvent(string $message): void
    {
        Log::info("Processing event: ", ['payload' => $message]);

        $unusedFiles = File::whereNotIn('id', FormEntry::pluck('file_id'))
            ->where('created_at', '<', Carbon::now()->subMinutes(self::UNUSED_FILE_THRESHOLD_MINUTES))
            ->get();

        foreach ($unusedFiles as $file) {
            $this->deleteFile($file);
        }

        Log::info('Unused files cleaned successfully.', ['count' => $unusedFiles->count()]);
    }

    private function deleteFile(File $file): void
    {
        try {
            if (\Storage::disk(self::STORAGE_DISK)->exists($file->path)) {
                \Storage::disk(self::STORAGE_DISK)->delete($file->path);
            }

            $file->delete();

            Log::info("Deleted unused file.", ['file_id' => $file->id, 'path' => $file->path]);
        } catch (\Exception $e) {
            Log::error("Failed to delete file.", ['file_id' => $file->id, 'exception' => $e->getMessage()]);
        }
    }
}
