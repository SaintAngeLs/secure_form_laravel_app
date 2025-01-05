@extends('layouts.app')

@section('content')
    <?php
    if (!function_exists('truncate')) {

        function truncate(?string $string, int $length = 10): string
        {
            if (!$string || strlen($string) <= $length) {
                return $string ?? 'N/A';
            }

            $half = intdiv($length, 2);

            return substr($string, 0, $half) . '...' . substr($string, -$half);
        }
    }
    ?>
    <div class="bg-gray-100 dark:bg-gray-900">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="text-2xl font-semibold">Dashboard</h1>
                        <p>Welcome back, {{ Auth::user()->name }}!</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Form Entries with File Details</h2>
                        @if($formEntries->isEmpty())
                            <p class="text-gray-500">No form entries available.</p>
                        @else
                            <table class="w-full text-left text-gray-700 dark:text-gray-300 border-collapse">
                                <thead class="border-b dark:border-gray-700">
                                    <tr>
                                        <th class="py-2 px-4">#</th>
                                        <th class="py-2 px-4">First Name</th>
                                        <th class="py-2 px-4">Last Name</th>
                                        <th class="py-2 px-4">File Name</th>
                                        <th class="py-2 px-4">File Path</th>
                                        <th class="py-2 px-4">File Size (KB)</th>
                                        <th class="py-2 px-4">Uploaded At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($formEntries as $entry)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer"
                                            onclick="window.location='{{ route('entry.show', $entry->id) }}'">
                                            <td class="py-2 px-4">{{ $loop->iteration }}</td>
                                            <td class="py-2 px-4">{{ truncate($entry->first_name, 10) }}</td>
                                            <td class="py-2 px-4">{{ truncate($entry->last_name, 10) }}</td>
                                            <td class="py-2 px-4">{{ $entry->file ? truncate($entry->file->name, 10) : 'N/A' }}</td>
                                            <td class="py-2 px-4">
                                                @if($entry->file)
                                                    <a href="{{ asset('storage/'.$entry->file->path) }}"
                                                       target="_blank"
                                                       class="text-blue-500 hover:underline"
                                                       onclick="event.stopPropagation();">
                                                        {{ truncate($entry->file->path, 20) }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="py-2 px-4">{{ $entry->file ? number_format($entry->file->size / 1024, 2) : 'N/A' }}</td>
                                            <td class="py-2 px-4">{{ $entry->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

