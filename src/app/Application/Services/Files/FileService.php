<?php

namespace App\Application\Services\Files;

use App\Domain\Repositories\IFileRepository;
use App\Domain\Entities\File as DomainFile;
use App\Application\DTO\FileDTO;
use App\Application\Exceptions\FileUploadException;
use App\Application\Services\Files\FileValidationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileService
{
    private IFileRepository $fileRepository;
    private FileValidationService $fileValidationService;

    public function __construct(IFileRepository $fileRepository, FileValidationService $fileValidationService)
    {
        $this->fileRepository = $fileRepository;
        $this->fileValidationService = $fileValidationService;
    }

    /**
     * Uploads a file and returns its metadata as a DTO.
     *
     * @param UploadedFile $file
     * @return FileDTO
     * @throws FileUploadException
     */
    public function uploadFile(UploadedFile $file): FileDTO
    {
        try {
            $this->fileValidationService->validate($file);

            $filePath = $file->store('uploads', 'public');
            if (!$filePath) {
                throw new FileUploadException('Failed to store the file.');
            }

            $domainFile = new DomainFile(
                $file->getClientOriginalName(),
                $filePath,
                $file->getClientOriginalExtension(),
                $file->getMimeType(),
                $file->getSize()
            );

            $savedFile = $this->fileRepository->save($domainFile);

            return new FileDTO(
                $savedFile->getId(),
                $savedFile->getName(),
                $savedFile->getPath(),
                $savedFile->getExtension(),
                $savedFile->getMimeType(),
                $savedFile->getSize()
            );

        } catch (FileUploadException $e) {
            Log::error("File upload failed: {$e->getMessage()}", ['exception' => $e]);
            throw $e;
        } catch (\Exception $e) {
            Log::error("Unexpected error in FileService@uploadFile: {$e->getMessage()}", ['exception' => $e]);
            throw new FileUploadException('An unexpected error occurred during file upload.', 0, $e);
        }
    }

    /**
     * Fetches a file by its ID and returns its metadata as a DTO.
     *
     * @param int $id
     * @return FileDTO|null
     * @throws FileUploadException
     */
    public function getFileById(int $id): ?FileDTO
    {
        try {
            $domainFile = $this->fileRepository->findById($id);

            if (!$domainFile) {
                return null;
            }

            return new FileDTO(
                $domainFile->getId(),
                $domainFile->getName(),
                $domainFile->getPath(),
                $domainFile->getExtension(),
                $domainFile->getMimeType(),
                $domainFile->getSize()
            );
        } catch (\Exception $e) {
            Log::error("Error fetching file by ID: {$e->getMessage()}", ['id' => $id, 'exception' => $e]);
            throw new FileUploadException("Failed to retrieve the file.", 0, $e);
        }
    }
}
