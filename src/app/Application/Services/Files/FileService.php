<?php

namespace App\Application\Services\Files;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile($file): array
    {
        $filePath = $file->store('uploads', 'public');

        return [
            'path' => $filePath,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
        ];
    }
}
