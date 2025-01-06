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

                        <form method="GET" action="{{ route('dashboard') }}" class="text-gray-800 mb-4 flex flex-col lg:flex-row items-start lg:items-center gap-4">
                            <div class="relative w-full lg:w-1/3">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search..."
                                    value="{{ request('search') }}"
                                    class="w-full px-8 py-2 text-sm text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                <div class="absolute top-2.5 right-8 text-gray-400 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m-3.65-7a7 7 0 1014 0 7 7 0 00-14 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="relative">
                                <select
                                    name="per_page"
                                    onchange="this.form.submit()"
                                    class="appearance-none px-7 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    @foreach([5, 10, 25, 50] as $option)
                                        <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                                            {{ $option }} per page
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button
                                type="submit"
                                class="flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                                Search
                            </button>
                        </form>

                        @if($formEntries->isEmpty())
                            <p class="text-gray-500">No form entries available.</p>
                        @else
                            <div class="overflow-x-auto">
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
                                                onclick="window.location='{{ route('dashboard.show', $entry->id) }}'">
                                                <td class="py-2 px-4">{{ $loop->iteration + ($formEntries->currentPage() - 1) * $formEntries->perPage() }}</td>
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
                            </div>

                            <div class="mt-4">
                                {{ $formEntries->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
