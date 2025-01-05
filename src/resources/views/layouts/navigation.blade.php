<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm2 0h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    <span class="text-2xl font-semibold text-blue-600 ml-3">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>

            <!-- Right Section -->
            <div class="hidden sm:flex space-x-8">
                <!-- Home Link -->
                <a href="/" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm">
                    Home
                </a>

                @auth
                    <!-- Authenticated Links -->
                    <a href="{{ route('dashboard') }}" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm">
                        Dashboard
                    </a>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-900 dark:text-gray-300">
                            <strong>{{ Auth::user()->name }}</strong>
                            <br>
                            <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm">
                                Sign Out
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm">
                        Sign Up
                    </a>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden">
                <button id="menu-toggle" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg id="menu-icon-open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="menu-icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden absolute top-16 left-0 w-full bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600 shadow-lg z-50">
        <div class="space-y-1 py-2">
            <!-- Home Link -->
            <a href="/" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm py-2 px-4">
                Home
            </a>

            @auth
                <!-- Authenticated Links -->
                <a href="{{ route('dashboard') }}" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm py-2 px-4">
                    Dashboard
                </a>
                <div class="px-4 py-2 text-sm text-gray-900 dark:text-gray-300">
                    <strong>{{ Auth::user()->name }}</strong>
                    <br>
                    <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="px-4">
                    @csrf
                    <button type="submit" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm py-2">
                        Sign Out
                    </button>
                </form>
            @endauth

            @guest
                <!-- Guest Links -->
                <a href="{{ route('login') }}" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm py-2 px-4">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="flex items-center text-gray-900 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 font-medium text-sm py-2 px-4">
                    Sign Up
                </a>
            @endguest
        </div>
    </div>
</nav>
