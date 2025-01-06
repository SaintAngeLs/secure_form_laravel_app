<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        @if (app()->environment('local'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ mix('css/app.css') }}">
            <script src="{{ mix('js/app.js') }}" defer></script>
        @endif
    </head>

    <body class="bg-gradient-to-br from-blue-50 to-blue-100 text-gray-900 flex flex-col min-h-screen font-sans antialiased">

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col items-center justify-center">
            <div class="mb-8">
                <a href="/" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm2 0h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    <span class="text-2xl font-semibold text-blue-600 ml-3">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>

            <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
                @yield('content')
            </div>
        </div>

        <footer class="bg-white dark:bg-gray-800 py-4">
            <div class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </footer>

    </body>
</html>
