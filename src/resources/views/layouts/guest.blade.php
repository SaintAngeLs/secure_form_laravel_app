<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dropzone.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 text-gray-900 font-inter antialiased min-h-screen">
<div class="flex flex-col items-center justify-center min-h-screen">
    <!-- Logo -->
    <div class="mb-8">
        <a href="/" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm2 0h-2v-6h2v6zm0-8h-2V7h2v2z"/>
            </svg>
            <span class="text-2xl font-semibold text-blue-600 ml-3">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <!-- Content Container -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="mt-8 text-sm text-gray-500">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </footer>
</div>
</body>
</html>
