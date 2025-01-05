import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

Dropzone.autoDiscover = false;

document.addEventListener('DOMContentLoaded', () => {
    const dropzoneElement = document.querySelector('#file-dropzone');

    if (dropzoneElement) {
        const dropzone = new Dropzone(dropzoneElement, {
            url: '/files/upload',
            maxFiles: 1,
            maxFilesize: 2,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            dictDefaultMessage: `
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    <p class="text-blue-600 mt-2">Drag & drop or click to upload an image</p>
                </div>
            `,
            success: function (file, response) {
                if (response.file && response.file.id) {

                    const fileIdInput = document.querySelector('#file_id');

                    if (fileIdInput) {
                        fileIdInput.value = response.file.id;
                    }
                    
                    console.log('File uploaded successfully. File ID:', response.file.id);
                } else {
                    console.error('File uploaded, but no file ID received:', response);
                }
            },
            error: function (file, response) {
                alert('An error occurred while uploading the file. Please try again.');
            },
        });

        window.clearDropzone = () => dropzone.removeAllFiles(true);
    }

});
