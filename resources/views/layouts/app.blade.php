<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlantis - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/4b9ba14b0f.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo și meniu -->
                <div class="flex items-center justify-between w-full">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                        Atlantis
                    </a>

                    <!-- Hamburger pentru mobile -->
                    @auth
                        <button type="button" class="sm:hidden" onclick="toggleMenu()">
                            <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    @endauth

                    <!-- Meniu desktop -->
                    @auth
                        <div class="hidden sm:flex sm:space-x-8">
                            <a href="{{ route('loads.index') }}" class="text-gray-500 hover:text-gray-700">Loads</a>
                            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'csr' || auth()->user()->role === 'ops')
                                <a href="{{ route('carriers.index') }}"
                                    class="text-gray-500 hover:text-gray-700">Carriers</a>
                            @endif
                            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'csr' || auth()->user()->role === 'sales')
                                <a href="{{ route('customers.index') }}"
                                    class="text-gray-500 hover:text-gray-700">Customers</a>
                            @endif
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700">Users</a>
                            @endif
                        </div>

                        <!-- User info & Logout -->
                        <div class="hidden sm:flex sm:items-center">
                            <span class="text-gray-700">{{ auth()->user()->username }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline-block ml-4">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Meniu mobile -->
            @auth
                <div id="mobile-menu" class="hidden sm:hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('loads.index') }}"
                            class="block px-3 py-2 text-gray-500 hover:text-gray-700">Loads</a>
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'csr' || auth()->user()->role === 'ops')
                            <a href="{{ route('carriers.index') }}"
                                class="block px-3 py-2 text-gray-500 hover:text-gray-700">Carriers</a>
                        @endif
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'csr' || auth()->user()->role === 'sales')
                            <a href="{{ route('customers.index') }}"
                                class="block px-3 py-2 text-gray-500 hover:text-gray-700">Customers</a>
                        @endif
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('users.index') }}"
                                class="block px-3 py-2 text-gray-500 hover:text-gray-700">Users</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="block px-3 py-2">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
    @stack('scripts')

    @auth
        <script>
            window.userRole = "{{ auth()->user()->role }}";
        </script>
        <div id="mobile-menu-mount"></div>
    @endauth
</body>

</html>
