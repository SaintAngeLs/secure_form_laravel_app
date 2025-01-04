<?php

namespace App\Infrastructure\Repositories\FormEntry;

use App\Domain\Repositories\IFormEntryRepository;
use App\Domain\Entities\FormEntry as DomainFormEntry;
use App\Infrastructure\Persistence\Models\FormEntry;

class FormEntryRepository implements IFormEntryRepository
{
    public function save(DomainFormEntry $formEntry): bool
    {
        return FormEntry::create([
            'first_name' => $formEntry->getFirstName(),
            'last_name' => $formEntry->getLastName(),
            'file_id' => $formEntry->getFileId(),
        ]) ? true : false;
    }

    public function getAll(): array
    {
        return FormEntry::with('file')->get()->toArray();
    }
}
