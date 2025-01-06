@extends('layouts.guest')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session()->has('message'))
   <div class="{{ session('type') === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} border px-4 py-3 rounded relative mb-4">
       <div>{{ session('message') }}</div>
   </div>
@endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <div class="block sm:inline">{{ session('error') }}</div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-semibold text-blue-600 text-center mb-6">Submit Your Details</h1>
        <form id="form-entry" method="POST" action="{{ route('form.create') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" id="first_name" name="first_name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <div id="first_name_error" class="text-red-500 text-sm"></div>
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" id="last_name" name="last_name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <div id="last_name_error" class="text-red-500 text-sm"></div>
            </div>
            <div>
                <label for="file-dropzone" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                <div id="file-dropzone" class="dropzone border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <!-- Dropzone UI -->
                </div>
                <div id="file_id_error" class="text-red-500 text-sm"></div>
                <input type="hidden" id="file_id" name="file_id">

            </div>

            <div>
                <button type="submit"
                        class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Submit
                </button>
            </div>
        </form>
    </div>

@endsection
