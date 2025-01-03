<?php

namespace App\Domain\Entities;

class FormEntry
{
    private string $firstName;
    private string $lastName;
    private string $filePath;

    public function __construct(string $firstName, string $lastName, string $filePath)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->filePath = $filePath;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
