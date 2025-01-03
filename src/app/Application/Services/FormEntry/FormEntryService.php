<?php

namespace App\Application\Services\FormEntry;

use App\Domain\Repositories\IFormEntryRepository;
use App\Domain\Entities\FormEntry;
use App\Application\DTO\FormEntryDTO;

class FormEntryService
{
    private IFormEntryRepository $repository;

    public function __construct(IFormEntryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createEntry(FormEntryDTO $dto): bool
    {
        $formEntry = new FormEntry($dto->firstName, $dto->lastName, $dto->filePath);
        return $this->repository->save($formEntry);
    }

    public function getEntries(): array
    {
        return $this->repository->getAll();
    }
}
