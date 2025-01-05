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
     * Handles file upload and returns a FileDTO response.
     *
     * @param UploadFileRequest $request
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * Lists all uploaded files.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $files = $this->fileService->getAllFiles();

            return response()->json([
                'files' => $files,
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error fetching files: {$e->getMessage()}", [
                'exception' => $e,
            ]);

            return response()->json([
                'error' => 'An error occurred while fetching files.',
            ], 500);
        }
    }
}
