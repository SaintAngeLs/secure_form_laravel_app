<?php

namespace App\Http\Controllers\FileForm;

use App\Http\Requests\StoreFormEntryRequest;
use App\Application\Services\FormEntry\FormEntryService;
use App\Application\DTO\FormEntryDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FormViewController extends Controller
{
    private FormEntryService $service;

    public function __construct(FormEntryService $service)
    {
        $this->service = $service;
    }

    public function store(StoreFormEntryRequest $request): RedirectResponse
    {
        $filePath = $request->file('file')->store('uploads', 'public');
        $dto = new FormEntryDTO(
            $request->get('first_name'),
            $request->get('last_name'),
            $filePath
        );

        if ($this->service->createEntry($dto)) {
            return redirect()->back()->with('success', 'Form submitted successfully.');
        }

        return redirect()->back()->with('error', 'Failed to submit form.');
    }

    public function userForm()
    {
        return view('user_form.form');
    }

    public function adminEntries()
    {
        $entries = $this->service->getEntries();
        return view('admin_form_entries.index', compact('entries'));
    }
}
