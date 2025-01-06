<?php

namespace App\Http\Controllers\FileForm;

use App\Http\Requests\StoreFormEntryRequest;
use App\Application\Services\FormEntry\FormEntryService;
use App\Application\Services\Files\FileService;
use App\Application\DTO\FormEntryDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class FormViewController extends Controller
{
    private FormEntryService $formEntryService;
    private FileService $fileService;

    public function __construct(FormEntryService $formEntryService, FileService $fileService)
    {
        $this->formEntryService = $formEntryService;
        $this->fileService = $fileService;
    }

    // public function store(StoreFormEntryRequest $request): RedirectResponse
    // {

    // }

    public function userForm()
    {
        try {
            return view('user_form.form');
        } catch (\Exception $e) {
            Log::error("Error in FormViewController@userForm: {$e->getMessage()}", [
                'exception' => $e,
            ]);

            return redirect()->route('form.userForm')->with('error', 'An error occurred while loading the form.');
        }
    }
}
