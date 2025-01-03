<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\FormEntry;

interface IFormEntryRepository
{
    public function save(FormEntry $formEntry): bool;
    public function getAll(): array;
}
