<?php

namespace App\Application\DTO;

class FileDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $path,
        public string $extension,
        public string $mimeType,
        public int $size
    ) {}
}
