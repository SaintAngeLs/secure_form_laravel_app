<?php

namespace App\Application\Exceptions;

class UserCreationException extends ApplicationException
{
    public function __construct($message = "User creation failed", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
