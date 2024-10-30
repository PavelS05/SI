@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
   <div class="flex justify-between items-center mb-6">
       <h2 class="text-2xl font-bold">Users</h2>
       <a href="{{ route('users.create') }}" 
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
           Add New User
       </a>
   </div>

   <!-- Users Table -->
   <div class="overflow-x-auto">
       <table class="min-w-full divide-y divide-gray-200">
           <thead class="bg-gray-50">
               <tr>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
               </tr>
           </thead>
           <tbody class="bg-white divide-y divide-gray-200">
               @foreach($users as $user)
               <tr>
                   <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                       <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                           @if($user->role === 'admin') bg-red-100 text-red-800
                           @elseif($user->role === 'ops') bg-blue-100 text-blue-800  
                           @elseif($user->role === 'sales') bg-green-100 text-green-800
                           @else bg-purple-100 text-purple-800
                           @endif">
                           {{ ucfirst($user->role) }}
                       </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                       <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
                       @if(auth()->user()->id !== $user->id)
                       <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                           @csrf
                           @method('DELETE')
                           <button type="submit" class="text-red-600 hover:text-red-900" 
                                   onclick="return confirm('Are you sure you want to delete this user?')">
                               Delete
                           </button>
                       </form>
                       @endif
                   </td>
               </tr>
               @endforeach
           </tbody>
       </table>
   </div>

   <div class="mt-4">
       {{ $users->links() }}
   </div>
</div>
@endsection