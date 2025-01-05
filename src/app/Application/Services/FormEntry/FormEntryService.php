<?php

namespace App\Application\Services\FormEntry;

use App\Domain\Repositories\IFormEntryRepository;
use App\Application\DTO\FormEntryDTO;
use App\Domain\Entities\FormEntry;
use App\Domain\Exceptions\FormEntryException;
use Illuminate\Support\Facades\Log;
use App\Application\Events\FormEntryCreated;
use Illuminate\Support\Facades\Event;
use App\Application\Services\Infrastructure\IMessageBroker;

class FormEntryService
{
    private IFormEntryRepository $repository;
    private IMessageBroker $messageBroker;

    public function __construct(IFormEntryRepository $repository, IMessageBroker $messageBroker)
    {
        $this->repository = $repository;
        $this->messageBroker = $messageBroker;
    }

    public function createEntry(FormEntryDTO $dto): bool
    {
        try {
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
