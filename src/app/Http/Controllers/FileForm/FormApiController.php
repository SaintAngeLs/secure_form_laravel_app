<?php

namespace App\Http\Controllers\FileForm;

use App\Application\Exceptions\FileNotFoundException;
use App\Application\Events\FormSubmittedEvent;
use App\Application\Services\Infrastructure\IMessageBroker;
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
    private IMessageBroker $messageBroker;
    // private FormEntryService $formEntryService;

    public function __construct(IMessageBroker $messageBroker)
    {
        $this->messageBroker = $messageBroker;
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
        try {
            $fileId = $request->get('file_id');

            if (!$fileId) {
                return response()->json(['error' => 'File upload is required.'], 422);
            }

            $formEntryDTO = new FormEntryDTO(
                $request->get('first_name'),
                $request->get('last_name'),
                $fileId
            );

            // if ($this->formEntryService->createEntry($dto)) {
            //     return response()->json(['message' => 'Form submitted successfully.'], 201);
            // }

            // return response()->json(['error' => 'Failed to submit form.'], 500);

            $this->messageBroker->publishAsync('form-submissions', json_encode($formEntryDTO));

             return response()->json(['message' => 'Form submitted successfully and is being processed.'], 201);

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
}
