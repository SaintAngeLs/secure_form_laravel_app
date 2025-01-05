<?php

namespace App\Application\Services\Files;

use App\Application\Exceptions\FileUploadException;

class FileValidationService
{
    private const MAX_FILE_SIZE = 2097152;
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

    /**
     * Validates the uploaded file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @throws FileUploadException
     */
    public function validate($file): void
    {
        if (!$file->isValid()) {
            throw new FileUploadException('The uploaded file is not valid.');
        }

        if (!in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES)) {
            throw new FileUploadException('The uploaded file must be an image (jpeg, png, gif).');
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new FileUploadException('The uploaded file must not exceed 2MB.');
        }
    }
}
