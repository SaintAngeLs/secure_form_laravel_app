<?php

namespace App\Domain\Exceptions;

use Exception;

class DomainException extends Exception
{
    public function report()
    {
        \Log::error("DomainException: {$this->getMessage()}");
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 500);
    }
}

