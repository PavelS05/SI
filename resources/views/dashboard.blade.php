{{-- dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->username }}!</h2>
            <p class="text-gray-600">Here's what's happening with your loads today.</p>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- New Loads Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 bg-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">New Loads</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $newLoads }}</p>
                        <p class="text-sm text-gray-600">Last 7 days</p>
                    </div>
                </div>
            </div>

            <!-- In Transit Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 bg-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">In Transit</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $inTransitLoads }}</p>
                        <p class="text-sm text-gray-600">Active loads</p>
                    </div>
                </div>
            </div>

            <!-- Dispatched Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 bg-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Dispatched</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $dispatchedLoads }}</p>
                        <p class="text-sm text-gray-600">Ready to move</p>
                    </div>
                </div>
            </div>

            <!-- Delivered Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 bg-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Delivered</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $deliveredLoads }}</p>
                        <p class="text-sm text-gray-600">This month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Loads -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Recent Loads</h3>
                        <a href="{{ route('loads.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($recentLoads as $load)
                            <li class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-900">Load #{{ $load->load_number }}</span>
                                            <span
                                                class="px-2  mx-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if ($load->status === 'New') bg-blue-100 text-blue-800
                            @elseif($load->status === 'Dispatched') bg-yellow-100 text-yellow-800
                            @elseif($load->status === 'In transit') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800 @endif">
                                                {{ ucfirst($load->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-1 flex items-center text-sm text-gray-500">
                                            <span>{{ $load->customer }}</span>
                                            <span class="mx-2">&bull;</span>
                                            <span>{{ $load->pu_date }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('loads.edit', $load) }}"
                                        class="ml-2 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Monthly Trends Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Trends</h3>
                <div class="h-64">
                    <canvas id="monthlyTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('monthlyTrendsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Loads',
                        data: @json($data),
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
