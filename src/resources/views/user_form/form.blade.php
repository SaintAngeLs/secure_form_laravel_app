@extends('layouts.guest')

@section('content')
    <h1 class="text-2xl font-semibold text-blue-600 text-center mb-6">Submit Your Details</h1>
    <form method="POST" action="{{ route('form.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <!-- First Name -->
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" id="first_name" name="first_name" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <!-- Last Name -->
        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" id="last_name" name="last_name" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <!-- File.php Upload -->
        <div>
            <label for="file-dropzone" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
            <div id="file-dropzone" class="dropzone border-2 border-dashed border-gray-300 rounded-lg p-4">
                <!-- Dropzone will populate content dynamically -->
            </div>
        </div>
        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Submit
            </button>
        </div>
    </form>
@endsection
