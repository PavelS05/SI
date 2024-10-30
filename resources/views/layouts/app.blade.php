<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlantis - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                            Atlantis
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    @auth
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('loads.index') }}" 
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Loads
                            </a>

                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'csr')
                            <a href="{{ route('carriers.index') }}"
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Carriers
                            </a>
                            @endif

                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'csr' || auth()->user()->role === 'sales')
                            <a href="{{ route('costumers.index') }}"
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Customers
                            </a>
                            @endif

                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('users.index') }}"
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Users
                            </a>
                            @endif
                        </div>
                    @endauth
                </div>

                <!-- Right Side -->
                <div class="flex items-center">
                    @auth
                        <div class="ml-3 relative">
                            <span class="text-gray-700">{{ auth()->user()->username }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline-block ml-4">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>