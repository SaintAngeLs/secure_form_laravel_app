<?php


namespace App\Domain\Exceptions;

use Exception;

class FormEntryException extends Exception
{
    public function __construct($message = "Form entry error", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        \Illuminate\Log::error("FormEntryException: {$this->getMessage()}");
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 500);
    }
}
