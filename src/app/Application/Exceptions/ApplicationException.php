<?php

namespace App\Application\Exceptions;

use Exception;

class ApplicationException extends Exception
{
    public function report()
    {
        \Log::error("ApplicationException: {$this->getMessage()}");
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 500);
    }
}
