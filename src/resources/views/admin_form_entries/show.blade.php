@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Detailed Form Entry -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Form Entry Details</h2>
                        <table class="w-full text-left text-gray-700 dark:text-gray-300 border-collapse">
                            <tbody>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-2 px-4">First Name</th>
                                    <td class="py-2 px-4">{{ $entry->first_name }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-2 px-4">Last Name</th>
                                    <td class="py-2 px-4">{{ $entry->last_name }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-2 px-4">File Name</th>
                                    <td class="py-2 px-4">{{ $entry->file->name ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-2 px-4">File Path</th>
                                    <td class="py-2 px-4">
                                        @if($entry->file)
                                            <a href="{{ asset('storage/'.$entry->file->path) }}" target="_blank" class="text-blue-500 hover:underline">
                                                {{ $entry->file->path }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-2 px-4">File Size</th>
                                    <td class="py-2 px-4">{{ $entry->file ? number_format($entry->file->size / 1024, 2) : 'N/A' }} KB</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="py-2 px-4">Uploaded At</th>
                                    <td class="py-2 px-4">{{ $entry->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
