<?php

namespace App\Application\Exceptions;

class FileUploadException extends ApplicationException
{
    public function __construct($message = "File upload error", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
