@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->username }}!</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Recent Loads</h3>
            <p class="text-3xl font-bold">
                {{ \App\Models\Load::where('created_at', '>=', now()->subDays(7))->count() }}
            </p>
            <p class="text-sm text-gray-600">In the last 7 days</p>
        </div>
        
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'csr')
        <div class="bg-green-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Active Carriers</h3>
            <p class="text-3xl font-bold">
                {{ \App\Models\Carrier::count() }}
            </p>
            <p class="text-sm text-gray-600">Total carriers</p>
        </div>
        @endif
        
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'sales' || auth()->user()->role === 'csr')
        <div class="bg-purple-100 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Active Customers</h3>
            <p class="text-3xl font-bold">
                {{ \App\Models\Costumer::count() }}
            </p>
            <p class="text-sm text-gray-600">Total customers</p>
        </div>
        @endif
    </div>
</div>
@endsection