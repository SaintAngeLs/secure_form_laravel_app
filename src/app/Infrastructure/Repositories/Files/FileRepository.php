<?php

namespace App\Infrastructure\Repositories\Files;

use App\Domain\Repositories\IFileRepository;
use App\Domain\Entities\File as DomainFile;
use App\Infrastructure\Persistence\Models\File as PersistenceFile;

class FileRepository implements IFileRepository
{
    /**
     * Save a DomainFile entity to the database.
     *
     * @param DomainFile $file
     * @return DomainFile
     */
    public function save(DomainFile $file): DomainFile
    {
        $persistenceFile = PersistenceFile::create([
            'name' => $file->getName(),
            'path' => $file->getPath(),
            'extension' => $file->getExtension(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return new DomainFile(
            $persistenceFile->name,
            $persistenceFile->path,
            $persistenceFile->extension,
            $persistenceFile->mime_type,
            $persistenceFile->size,
            $persistenceFile->id
        );
    }

    /**
     * Find a file by its ID.
     *
     * @param int $id
     * @return DomainFile|null
     */
    public function findById(int $id): ?DomainFile
    {
        $persistenceFile = PersistenceFile::find($id);

        if (!$persistenceFile) {
            return null;
        }

        return new DomainFile(
            $persistenceFile->name,
            $persistenceFile->path,
            $persistenceFile->extension,
            $persistenceFile->mime_type,
            $persistenceFile->size,
            $persistenceFile->id
        );
    }
}
