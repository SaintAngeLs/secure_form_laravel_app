<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\File as DomainFile;

interface IFileRepository
{
    public function save(DomainFile $file): DomainFile;
    public function findById(int $id): ?DomainFile;
}
