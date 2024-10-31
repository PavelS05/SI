@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Customer</h2>
                    <p class="mt-1 text-sm text-gray-600">Update the customer's information in the system.</p>
                </div>

                <!-- Form -->
                <div class="px-6 py-6">
                    <form action="{{ route('customers.update', $customer) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <div class="text-lg font-medium text-gray-900 pb-2 border-b border-gray-200">
                                Basic Information
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Customer
                                        Name</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" name="name" id="name" value="{{ $customer->name }}"
                                            required
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Enter customer name">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="dbo" class="block text-sm font-medium text-gray-700">DBA</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" name="dbo" id="dbo" value="{{ $customer->dbo }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Enter DBA">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="credit" class="block text-sm font-medium text-gray-700">Credit
                                        Amount</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="credit" id="credit" value="{{ $customer->credit }}"
                                            class="block w-full pl-7 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="0.00">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select name="status" id="status" required
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="active" {{ $customer->status === 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ $customer->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="space-y-6">
                            <div class="text-lg font-medium text-gray-900 pb-2 border-b border-gray-200">
                                Contact Information
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label for="contact_name" class="block text-sm font-medium text-gray-700">Contact
                                        Name</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" name="contact_name" id="contact_name"
                                            value="{{ $customer->contact_name }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Enter contact name">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="tel" name="phone" id="phone" value="{{ $customer->phone }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="(555) 555-5555">
                                    </div>
                                </div>

                                <div class="space-y-1 md:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="email" name="email" id="email" value="{{ $customer->email }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="customer@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sales Representatives Section -->
                        <div class="space-y-6">
                            <div class="text-lg font-medium text-gray-900 pb-2 border-b border-gray-200">
                                Sales Representatives
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label for="sales_rep1" class="block text-sm font-medium text-gray-700">Sales Rep
                                        1</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" name="sales_rep1" id="sales_rep1"
                                            value="{{ $customer->sales_rep1 }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Enter Sales Rep 1">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="sales_rep2" class="block text-sm font-medium text-gray-700">Sales Rep
                                        2</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" name="sales_rep2" id="sales_rep2"
                                            value="{{ $customer->sales_rep2 }}"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Enter Sales Rep 2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('customers.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Update Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
