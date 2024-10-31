@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Welcome, {{ auth()->user()->username }}!</h2>

        <!-- Main Stats -->
        <div class="flex flex-wrap gap-4 mb-4">
            <div class="bg-blue-100 rounded-lg p-4 w-full sm:w-[calc(50%-0.5rem)]">
                <h3 class="text-sm font-medium text-gray-700">Recent Loads</h3>
                <p class="text-2xl font-bold">{{ $newLoads }}</p>
                <p class="text-xs text-gray-600">In the last 7 days</p>
            </div>

            <div class="bg-yellow-100 rounded-lg p-4 w-full sm:w-[calc(50%-0.5rem)]">
                <h3 class="text-sm font-medium text-gray-700">In Transit</h3>
                <p class="text-2xl font-bold">{{ $inTransitLoads }}</p>
            </div>

            <div class="bg-green-100 rounded-lg p-4 w-full sm:w-[calc(50%-0.5rem)]">
                <h3 class="text-sm font-medium text-gray-700">Dispatched</h3>
                <p class="text-2xl font-bold">{{ $dispatchedLoads }}</p>
            </div>

            <div class="bg-purple-100 rounded-lg p-4 w-full sm:w-[calc(50%-0.5rem)]">
                <h3 class="text-sm font-medium text-gray-700">Delivered</h3>
                <p class="text-2xl font-bold">{{ $deliveredLoads }}</p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Recent Activity</h3>
            <div class="space-y-2">
                @foreach ($recentLoads as $load)
                    <div class="flex items-center justify-between border-b pb-2">
                        <div>
                            <p class="font-medium text-sm">Load #{{ $load->load_number }}</p>
                            <p class="text-xs text-gray-600">{{ $load->costumer }}</p>
                        </div>
                        <span
                            class="px-2 py-1 text-xs font-semibold rounded-full
                       @if ($load->status === 'new') bg-blue-100 text-blue-800
                       @elseif($load->status === 'dispatched') bg-green-100 text-green-800
                       @elseif($load->status === 'in_transit') bg-yellow-100 text-yellow-800
                       @else bg-purple-100 text-purple-800 @endif">
                            {{ ucfirst($load->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
