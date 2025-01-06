<?php

namespace App\Application\Services\FormEntry;

use App\Application\Exceptions\FileNotFoundException;
use App\Domain\Repositories\IFormEntryRepository;
use App\Application\DTO\FormEntryDTO;
use App\Domain\Entities\FormEntry;
use App\Domain\Exceptions\FormEntryException;
use Illuminate\Support\Facades\Log;
use App\Application\Events\FormEntryCreated;
use Illuminate\Support\Facades\Event;
use App\Application\Services\Infrastructure\IMessageBroker;
use App\Application\Services\Files\FileService;

class FormEntryService
{
    private IFormEntryRepository $repository;
    private IMessageBroker $messageBroker;
    private FileService $fileService;

    public function __construct(
        IFormEntryRepository $repository,
        IMessageBroker $messageBroker,
        FileService $fileService
    ) {
        $this->repository = $repository;
        $this->messageBroker = $messageBroker;
        $this->fileService = $fileService;
    }

    public function createEntry(FormEntryDTO $dto): bool
    {
        try {
            $file = $this->fileService->getFileById($dto->fileId);

            if (!$file) {
                Log::warning("File with ID {$dto->fileId} not found.");
                throw new FileNotFoundException("The file with ID {$dto->fileId} does not exist.");
            }

            $formEntry = new FormEntry($dto->firstName, $dto->lastName, $dto->fileId);

            $result = $this->repository->save($formEntry);

            if ($result) {
                $this->messageBroker->publishAsync('form-entries', json_encode([
                    'first_name' => $formEntry->getFirstName(),
                    'last_name' => $formEntry->getLastName(),
                    'file_id' => $formEntry->getFileId(),
                ]));
            }

            return $result;
        } catch (\Exception $e) {
            Log::error("Error creating form entry: {$e->getMessage()}", [
                'dto' => $dto,
                'exception' => $e,
            ]);

            throw new FormEntryException("Failed to create form entry.", 0, $e);
        }
    }

    public function getEntries(): array
    {
        try {
            return $this->repository->getAll();
        } catch (\Exception $e) {
            Log::error("Error retrieving form entries: {$e->getMessage()}", ['exception' => $e]);
            throw new FormEntryException("Failed to retrieve form entries.", 0, $e);
        }
    }
}
