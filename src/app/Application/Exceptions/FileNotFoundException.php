<?php

namespace App\Application\Exceptions;

class FileNotFoundException extends ApplicationException
{
    public function __construct($message = "File not found", $code = 404, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
