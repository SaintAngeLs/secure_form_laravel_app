<?php

namespace App\Http\Controllers\FileForm;

use App\Application\Services\FormEntry\FormEntryService;
use App\Application\DTO\FormEntryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormEntryRequest;
use Illuminate\Http\JsonResponse;

class FormApiController extends Controller
{
    private FormEntryService $service;

    public function __construct(FormEntryService $service)
    {
        $this->service = $service;
    }

    public function store(StoreFormEntryRequest $request): JsonResponse
    {
        $filePath = $request->file('file')->store('uploads', 'public');
        $dto = new FormEntryDTO(
            $request->get('first_name'),
            $request->get('last_name'),
            $filePath
        );

        if ($this->service->createEntry($dto)) {
            return response()->json(['message' => 'Form submitted successfully.'], 201);
        }

        return response()->json(['message' => 'Failed to submit form.'], 500);
    }

    public function index(): JsonResponse
    {
        $entries = $this->service->getEntries();
        return response()->json(['data' => $entries], 200);
    }
}
