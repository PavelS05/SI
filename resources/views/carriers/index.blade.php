@extends('layouts.app')

@section('title', 'Carriers')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Carriers</h2>
        <a href="{{ route('carriers.create') }}" 
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Carrier
        </a>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <form action="{{ route('carriers.index') }}" method="GET">
            <input type="text" name="search" placeholder="Search carriers..." value="{{ request('search') }}"
                   class="w-full px-4 py-2 border rounded-lg">
        </form>
    </div>

    <!-- Carriers Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">MC#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Insurance</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($carriers as $carrier)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $carrier->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $carrier->mc }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $carrier->contact_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $carrier->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $carrier->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($carrier->insurance) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('carriers.edit', $carrier) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
                        <form action="{{ route('carriers.destroy', $carrier) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $carriers->links() }}
    </div>
</div>
@endsection