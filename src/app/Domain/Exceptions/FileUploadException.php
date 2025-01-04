<?php

namespace App\Domain\Exceptions;

use Exception;

class FileUploadException extends Exception
{
    public function __construct($message = "File upload error", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        \Log::error("FileUploadException: {$this->getMessage()}");
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 500);
    }
}
