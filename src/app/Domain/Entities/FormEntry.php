<?php

namespace App\Domain\Entities;

use App\Domain\Events\FormSubmitted;

class FormEntry extends AggregateRoot
{
    private string $firstName;
    private string $lastName;
    private int $fileId;

    public function __construct(string $firstName, string $lastName, int $fileId, ?int $id = null)
    {
        parent::__construct($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->fileId = $fileId;

        $this->addEvent(new FormSubmitted($this));
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

    public function updateDetails(string $firstName, string $lastName): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
