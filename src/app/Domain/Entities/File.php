<?php

namespace App\Domain\Entities;

use App\Domain\Events\FileUploaded;

class File extends AggregateRoot
{
    private string $name;
    private string $path;
    private string $extension;
    private string $mimeType;
    private int $size;

    public function __construct(
        string $name,
        string $path,
        string $extension,
        string $mimeType,
        int $size,
        ?int $id = null
    ) {
        parent::__construct($id);
        $this->name = $name;
        $this->path = $path;
        $this->extension = $extension;
        $this->mimeType = $mimeType;
        $this->size = $size;

        $this->addEvent(new FileUploaded($this));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
