<?php

namespace App\Application\Services\FormEntry;

use App\Domain\Repositories\IFormEntryRepository;
use App\Application\DTO\FormEntryDTO;
use App\Domain\Entities\FormEntry;
use App\Domain\Exceptions\FormEntryException;
use Illuminate\Support\Facades\Log;

class FormEntryService
{
    private IFormEntryRepository $repository;

    public function __construct(IFormEntryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createEntry(FormEntryDTO $dto): bool
    {
        try {
            $formEntry = new FormEntry($dto->firstName, $dto->lastName, $dto->fileId);
            return $this->repository->save($formEntry);
        } catch (\Exception $e) {
            // Log::error("Error creating form entry: {$e->getMessage()}", ['dto' => $dto, 'exception' => $e]);
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
