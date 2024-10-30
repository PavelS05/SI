@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
   <div class="flex justify-between items-center mb-6">
       <h2 class="text-2xl font-bold">Customers</h2>
       <a href="{{ route('costumers.create') }}" 
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
           Add New Customer
       </a>
   </div>

   <!-- Search -->
   <div class="mb-4">
       <form action="{{ route('costumers.index') }}" method="GET">
           <input type="text" name="search" placeholder="Search customers..." value="{{ request('search') }}"
                  class="w-full px-4 py-2 border rounded-lg">
       </form>
   </div>

   <!-- Customers Table -->
   <div class="overflow-x-auto">
       <table class="min-w-full divide-y divide-gray-200">
           <thead class="bg-gray-50">
               <tr>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact Name</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Credit</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
               </tr>
           </thead>
           <tbody class="bg-white divide-y divide-gray-200">
               @foreach($costumers as $costumer)
               <tr>
                   <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->name }}</td>
                   <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->contact_name }}</td>
                   <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->phone }}</td>
                   <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->email }}</td>
                   <td class="px-6 py-4 whitespace-nowrap">${{ number_format($costumer->credit) }}</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                       <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                           @if($costumer->status === 'active') bg-green-200 text-green-800
                           @else bg-red-200 text-red-800
                           @endif">
                           {{ ucfirst($costumer->status) }}
                       </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                       <a href="{{ route('costumers.edit', $costumer) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
                       <form action="{{ route('costumers.destroy', $costumer) }}" method="POST" class="inline-block">
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
       {{ $costumers->links() }}
   </div>
</div>
@endsection