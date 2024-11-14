@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Customers</h2>
                <a href="{{ route('customers.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Add New Customer
                </a>
            </div>

            <!-- Search -->
            <div class="px-6 py-4 bg-gray-50">
                <form action="{{ route('customers.index') }}" method="GET">
                    <div class="flex space-x-2">
                        <input type="text" name="search" placeholder="Search customers..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 rounded-l-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('customers.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 ease-in-out">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Customers Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Credit Line</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                    @if ($customer->dbo)
                                        <div class="text-sm text-gray-500">DBA: {{ $customer->dbo }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->contact_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="tel:{{ $customer->phone }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        {{ $customer->phone }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="mailto:{{ $customer->email }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm">
                                        {{ $customer->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($customer->credit, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('customers.edit', $customer) }}"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200 delete-customer"
                                            data-customer-id="{{ $customer->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>No customers found</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="md:hidden space-y-4">
                    @foreach ($customers as $customer)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Customer Name</span>
                                        <p class="text-lg font-bold text-gray-900">{{ $customer->name }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 gap-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-gray-400 w-5"></i>
                                        <span class="ml-2">{{ $customer->contact_name }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 w-5"></i>
                                        <a href="tel:{{ $customer->phone }}" class="ml-2 text-blue-600">
                                            {{ $customer->phone }}
                                        </a>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 w-5"></i>
                                        <a href="mailto:{{ $customer->email }}" class="ml-2 text-blue-600">
                                            {{ $customer->email }}
                                        </a>
                                    </div>

                                    <div class="flex items-center">
                                        <i class="fas fa-dollar-sign text-gray-400 w-5"></i>
                                        <span class="ml-2">${{ number_format($customer->credit, 2) }}</span>
                                    </div>

                                    @if ($customer->sales_rep1)
                                        <div class="flex items-center">
                                            <i class="fas fa-user-tie text-gray-400 w-5"></i>
                                            <span class="ml-2">Rep: {{ $customer->sales_rep1 }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="pt-3 border-t border-gray-200 flex justify-end space-x-3">
                                    <a href="{{ route('customers.edit', $customer) }}"
                                        class="inline-flex items-center px-3 py-2 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-red-600 rounded-md text-sm font-medium text-red-600 hover:bg-red-50 delete-customer"
                                        data-customer-id="{{ $customer->id }}">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    @include('partials.delete-modal')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initializeDeleteModal({
                    itemType: 'Customer', // sau 'Customer', 'Load' etc
                    deleteUrl: '/customers/', // sau '/customers/', '/loads/' etc
                });
            });
        </script>
    @endpush
@endsection
