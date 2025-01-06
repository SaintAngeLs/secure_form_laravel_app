<?php

namespace App\Http\Controllers\FileForm;

use App\Application\Exceptions\FileNotFoundException;
use App\Application\Services\FormEntry\FormEntryService;
use App\Application\DTO\FormEntryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormEntryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *     title="Secure Form API",
 *     version="1.0.0",
 * )
 */
class FormApiController extends Controller
{
    private FormEntryService $formEntryService;

    public function __construct(FormEntryService $formEntryService)
    {
        $this->formEntryService = $formEntryService;
    }

    /**
     * @OA\Post(
     *     path="/api/form",
     *     summary="Submit form",
     *     summary="Submit a form",
     *     tags={"Form Submission"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="file_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Form submitted successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */
    public function store(StoreFormEntryRequest $request): JsonResponse
    {
        Log::info('Request data received in FormApiController@store', [
            'request_data' => $request->all(),
        ]);

        try {
            $fileId = $request->get('file_id');

            if (!$fileId) {
                return response()->json(['error' => 'File upload is required.'], 422);
            }

            $dto = new FormEntryDTO(
                $request->get('first_name'),
                $request->get('last_name'),
                $fileId
            );

            if ($this->formEntryService->createEntry($dto)) {
                return response()->json(['message' => 'Form submitted successfully.'], 201);
            }

            return response()->json(['error' => 'Failed to submit form.'], 500);
        } catch (FileNotFoundException $e) {
            Log::warning("File not found in FormApiController@store: {$e->getMessage()}", [
                'file_id' => $request->get('file_id'),
            ]);

            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            Log::error("Error in FormApiController@store: {$e->getMessage()}", [
                'request' => $request->all(),
                'exception' => $e,
            ]);

            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $entries = $this->formEntryService->getEntries();
            return response()->json(['data' => $entries], 200);
        } catch (\Exception $e) {
            Log::error("Error in FormApiController@index: {$e->getMessage()}", [
                'exception' => $e,
            ]);

            return response()->json(['error' => 'An error occurred while retrieving entries.'], 500);
        }
    }
}
