@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
   <div class="bg-white shadow rounded-lg p-6">
       <h2 class="text-2xl font-bold mb-6">Add New Customer</h2>

       <form action="{{ route('costumers.store') }}" method="POST" class="space-y-6">
           @csrf
           
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div>
                   <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                   <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">DBA</label>
                   <input type="text" name="dbo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Contact Name</label>
                   <input type="text" name="contact_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Phone</label>
                   <input type="text" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Email</label>
                   <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Credit Amount</label>
                   <input type="number" name="credit" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Sales Rep 1</label>
                   <input type="text" name="sales_rep1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Sales Rep 2</label>
                   <input type="text" name="sales_rep2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
               </div>

               <div>
                   <label class="block text-sm font-medium text-gray-700">Status</label>
                   <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                       <option value="active">Active</option>
                       <option value="inactive">Inactive</option>
                   </select>
               </div>
           </div>

           <div class="flex justify-end gap-4">
               <a href="{{ route('costumers.index') }}" 
                  class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                   Cancel
               </a>
               <button type="submit"
                       class="bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 border border-transparent rounded-md shadow-sm focus:outline-none">
                   Create Customer
               </button>
           </div>
       </form>
   </div>
</div>
@endsection