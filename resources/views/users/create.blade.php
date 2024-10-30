@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Add New User</h2>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Username</label>
                        <input type="text" name="username" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-800">Password</label>
                        <input type="password" name="password" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        <p class="mt-1 text-sm text-gray-00">*Parola trebuie să aibă minim 6 caractere.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300">Role</label>
                        <select name="role" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            <option value="admin">Admin</option>
                            <option value="ops">Ops</option>
                            <option value="sales">Sales</option>
                            <option value="csr">CSR</option>
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
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
