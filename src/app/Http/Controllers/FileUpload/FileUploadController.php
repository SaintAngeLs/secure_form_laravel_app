<?php

namespace App\Http\Controllers\FileUpload;

use App\Application\Services\Files\FileService;
use App\Http\Requests\UploadFileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @OA\Post(
     *     path="/files/upload",
     *     summary="Upload a file",
     *     tags={"File Upload"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="file", type="file", description="File to upload")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="File uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="File uploaded successfully"),
     *             @OA\Property(property="file", type="object", description="Uploaded file details")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred during file upload",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="An error occurred during file upload. Please try again later."),
     *             @OA\Property(property="details", type="string", example="Error details here.")
     *         )
     *     )
     * )
     */
    public function upload(UploadFileRequest $request)
    {
        try {
            $uploadedFile = $request->file('file');

            $fileDTO = $this->fileService->uploadFile($uploadedFile);

            return response()->json([
                'message' => 'File uploaded successfully',
                'file' => $fileDTO,
            ], 201);

        } catch (\Exception $e) {
            Log::error("File upload error: {$e->getMessage()}", [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            return response()->json([
                'error' => 'An error occurred during file upload. Please try again later.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
