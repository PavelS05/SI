@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (in_array(auth()->user()->role, ['sales', 'admin']))
            {{-- Sales Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-blue-800">New Loads</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $newLoads }}</p>
                    <p class="text-sm text-blue-600">Last 7 days</p>
                </div>
                <div class="bg-yellow-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-yellow-800">Dispatched</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $dispatchedLoads }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-purple-800">In Transit</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $inTransitLoads }}</p>
                </div>
                <div class="bg-green-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-green-800">Delivered</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $deliveredLoads }}</p>
                    <p class="text-sm text-green-600">This month</p>
                </div>
            </div>
        @elseif(auth()->user()->role === 'ops')
            {{-- Ops Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-blue-800">Dispatched Today</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $dispatchedToday }}</p>
                </div>
                <div class="bg-red-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-red-800">Urgent Loads</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $urgentLoads }}</p>
                    <p class="text-sm text-red-600">Pickup within 48h</p>
                </div>
                <div class="bg-yellow-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-yellow-800">Unassigned</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $unassignedLoads }}</p>
                </div>
            </div>
        @elseif(auth()->user()->role === 'csr')
            {{-- CSR Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-blue-800">Active Carriers</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $activeCarriers }}/{{ $totalCarriers }}</p>
                </div>
                <div class="bg-green-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-green-800">Active Customers</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $activeCustomers }}/{{ $totalCustomers }}</p>
                </div>
                <div class="bg-yellow-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-yellow-800">Pending Loads</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $pendingLoads }}</p>
                </div>
                <!-- Add more cards here completedLoads -->
                <div class="bg-purple-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-purple-800">Completed Loads</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $completedLoads }}</p>
                    <p class="text-sm text-purple-600">This month</p>
                </div>
            </div>
        @endif

        {{-- Recent Loads Table - Common for all roles --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Recent Loads</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Load #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PU Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentLoads as $load)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $load->load_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $load->customer }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if ($load->status === 'New') bg-blue-100 text-blue-800
                                    @elseif($load->status === 'Dispatched') bg-yellow-100 text-yellow-800
                                    @elseif($load->status === 'In transit') bg-purple-100 text-purple-800
                                    @else bg-green-100 text-green-800 @endif">
                                        {{ $load->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $load->pu_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('loads.edit', $load) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
