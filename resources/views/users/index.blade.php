@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2 sm:mb-0">Users</h2>
                <a href="{{ route('users.create') }}"
                    class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Add New User
                </a>
            </div>

            <!-- Users Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if ($user->role === 'admin') bg-red-100 text-red-800
                                        @elseif($user->role === 'ops') bg-blue-100 text-blue-800  
                                        @elseif($user->role === 'sales') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-4">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    @if (auth()->user()->id !== $user->id)
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-user"
                                            data-user-id="{{ $user->id }}">
                                            <i class="fas fa-trash-alt mr-1"></i>Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (vizibile doar pe mobile) -->
            <div class="md:hidden space-y-4">
                @foreach ($users as $user)
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-medium">{{ $user->username }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                        @if ($user->role === 'admin') bg-red-100 text-red-800
                        @elseif($user->role === 'ops') bg-blue-100 text-blue-800
                        @elseif($user->role === 'sales') bg-green-100 text-green-800
                        @else bg-purple-100 text-purple-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if (auth()->user()->id !== $user->id)
                                    <button type="button" class="text-red-600 hover:text-red-800 delete-user"
                                        data-user-id="{{ $user->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @include('partials.delete-modal')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initializeDeleteModal({
                    itemType: 'User', // sau 'Customer', 'Load' etc
                    deleteUrl: '/users/', // sau '/customers/', '/loads/' etc
                });
            });
        </script>
    @endpush
@endsection
