<?php

namespace App\Domain\Entities;

class FormEntry
{
    private string $firstName;
    private string $lastName;
    private int $fileId;

    public function __construct(string $firstName, string $lastName, int $fileId)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->fileId = $fileId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFileId(): int
    {
        return $this->fileId;
    }
}
