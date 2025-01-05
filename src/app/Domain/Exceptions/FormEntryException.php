<?php


namespace App\Domain\Exceptions;

use Exception;

class FormEntryException extends DomainException
{
    public function __construct($message = "Form entry error", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
