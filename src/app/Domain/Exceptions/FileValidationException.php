<?php

namespace App\Domain\Exceptions;

class FileValidationException extends DomainException
{
    public function __construct($message = "File validation error", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
