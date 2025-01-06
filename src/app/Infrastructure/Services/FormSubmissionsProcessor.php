<?php

namespace App\Infrastructure\Services;

use App\Application\DTO\FormEntryDTO;
use App\Application\Services\FormEntry\FormEntryService;
use App\Application\Services\Infrastructure\IMessageBroker;
use Illuminate\Support\Facades\Log;

class FormSubmissionsProcessor
{
    private IMessageBroker $messageBroker;
    private FormEntryService $formEntryService;
    private const TOPIC_NAME = 'form-submissions';

    public function __construct(IMessageBroker $messageBroker, FormEntryService $formEntryService)
    {
        $this->messageBroker = $messageBroker;
        $this->formEntryService = $formEntryService;
    }

    /**
     * Subscribe to the form submissions topic and process incoming messages.
     */
    public function handleFormSubmissions(): void
    {
        Log::info("Subscribing to Kafka topic: " . self::TOPIC_NAME);

        $this->messageBroker->subscribeAsync(self::TOPIC_NAME, function ($message) {
            Log::info("Message received from topic: " . self::TOPIC_NAME, ['message' => $message]);

            try {
                $this->processSubmission($message);
            } catch (\Exception $e) {
                Log::error("Error processing form submission.", [
                    'message' => $message,
                    'exception' => $e->getMessage()
                ]);
            }
        });
    }

    /**
     * Process a single form submission message.
     *
     * @param string $message
     */
    private function processSubmission(string $message): void
    {
        Log::info("Processing form submission message: ", ['payload' => $message]);

        try {
            $data = json_decode($message, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException("Invalid JSON payload.");
            }

            $mappedData = [
                'first_name' => $data['firstName'] ?? null,
                'last_name' => $data['lastName'] ?? null,
                'file_id' => $data['fileId'] ?? null,
            ];

            if (empty($mappedData['first_name']) || empty($mappedData['last_name']) || empty($mappedData['file_id'])) {
                throw new \InvalidArgumentException("Missing required fields in payload.");
            }

            $formEntryDTO = new FormEntryDTO(
                $mappedData['first_name'],
                $mappedData['last_name'],
                (int) $mappedData['file_id']
            );

            $this->formEntryService->createEntry($formEntryDTO);
            Log::info("Form submission processed successfully.", ['data' => $mappedData]);

        } catch (\Exception $e) {
            Log::error("Failed to process form submission.", [
                'payload' => $message,
                'exception' => $e->getMessage()
            ]);
        }
    }
}
