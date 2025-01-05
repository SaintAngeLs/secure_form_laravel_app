<?php

namespace App\Domain\Events;

use App\Domain\Entities\File;

class FileUploaded implements DomainEvent
{
    private File $file;
    private \DateTimeImmutable $occurredOn;

    public function __construct(File $file)
    {
        $this->file = $file;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
