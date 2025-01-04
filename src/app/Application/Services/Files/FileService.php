<?php

namespace App\Application\Services\Files;

use Illuminate\Support\Facades\Storage;
use App\Infrastructure\Persistence\Models\File;
use App\Domain\Exceptions\FileUploadException;

class FileService
{
    public function uploadFile($file): array
    {
        try {
            $filePath = $file->store('uploads', 'public');

            if (!$filePath) {
                throw new FileUploadException('Failed to store the file.');
            }

            $fileRecord = File::create([
                'path' => $filePath,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getMimeType(),
            ]);

            return [
                'file_id' => $fileRecord->id,
                'path' => $filePath,
                'name' => $fileRecord->name,
                'size' => $fileRecord->size,
                'extension' => $fileRecord->extension,
                'mime_type' => $fileRecord->mime_type,
            ];
        } catch (\Exception $e) {
            throw new FileUploadException('An error occurred during file upload: ' . $e->getMessage(), 0, $e);
        }
    }
}
