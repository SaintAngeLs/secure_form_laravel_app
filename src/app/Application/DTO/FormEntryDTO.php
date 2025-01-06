<?php

namespace App\Application\DTO;

class FormEntryDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $fileId
    ) {}
}
