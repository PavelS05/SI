@extends('layouts.app')

@section('title', 'Edit Carrier')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
   <div class="bg-white shadow rounded-lg p-6">
       <h2 class="text-2xl font-bold mb-6">Edit Carrier</h2>

       <form action="{{ route('carriers.update', $carrier) }}" method="POST" class="space-y-6">
           @csrf
           @method('PUT')
           
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div>
                   <label class="block text-sm font-medium text-gray-700">Carrier Name</label>
                   <input type="text" name="name" value="{{ $carrier->name }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">MC Number</label>
                   <input type="text" name="mc" value="{{ $carrier->mc }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">DBA</label>
                   <input type="text" name="dbo" value="{{ $carrier->dbo }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Contact Name</label>
                   <input type="text" name="contact_name" value="{{ $carrier->contact_name }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Phone</label>
                   <input type="text" name="phone" value="{{ $carrier->phone }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Email</label>
                   <input type="email" name="email" value="{{ $carrier->email }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Insurance Amount</label>
                   <input type="number" name="insurance" value="{{ $carrier->insurance }}" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>
           </div>

           <div>
               <label class="block text-sm font-medium text-gray-700">Notes</label>
               <textarea name="notes" rows="3" 
                         class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">{{ $carrier->notes }}</textarea>
           </div>

           <div class="flex justify-end gap-4">
               <a href="{{ route('carriers.index') }}" 
                  class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                   Cancel
               </a>
               <button type="submit"
                       class="bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 border border-transparent rounded-md shadow-sm focus:outline-none">
                   Update Carrier
               </button>
           </div>
       </form>
   </div>
</div>
@endsection