<?php

namespace App\Http\Controllers\FileUpload;

use App\Application\Services\Files\FileService;
use App\Http\Requests\UploadFileRequest;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\File;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(UploadFileRequest $request)
    {
        $fileData = $this->fileService->uploadFile($request->file('file'));

        $file = File::create([
            'name' => $fileData['name'],
            'path' => $fileData['path'],
            'extension' => $fileData['extension'],
            'mime_type' => $fileData['mime_type'],
            'size' => $fileData['size'],
            'uploader_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'File uploaded successfully', 'file' => $file], 201);
    }

    public function index()
    {
        $files = File::with('uploader')->get();
        return response()->json(['files' => $files], 200);
    }
}
