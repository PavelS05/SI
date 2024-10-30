@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Edit User</h2>

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password (leave empty to keep current)</label>
                    <input type="password" name="password" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="ops" {{ $user->role === 'ops' ? 'selected' : '' }}>Ops</option>
                        <option value="sales" {{ $user->role === 'sales' ? 'selected' : '' }}>Sales</option>
                        <option value="csr" {{ $user->role === 'csr' ? 'selected' : '' }}>CSR</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('users.index') }}" 
                   class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 border border-transparent rounded-md shadow-sm focus:outline-none">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection