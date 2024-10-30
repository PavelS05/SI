@extends('layouts.app')

@section('title', 'Create Load')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Create New Load</h2>

            <form action="{{ route('loads.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Load Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Load Number</label>
                        <input type="text" disabled placeholder="Will be generated automatically"
                            class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            <option value="new">New</option>
                            <option value="dispatched">Dispatched</option>
                            <option value="in_transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>

                    <div>
                        <label for="service" class="block text-sm font-medium text-gray-700">Service Type</label>
                        <input type="text" name="service" id="service"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="costumer" class="block text-sm font-medium text-gray-700">Customer</label>
                            <input type="text" name="costumer" id="costumer"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="costumer_rate" class="block text-sm font-medium text-gray-700">Customer Rate</label>
                            <input type="number" name="costumer_rate" id="costumer_rate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="sales" class="block text-sm font-medium text-gray-700">Sales Rep</label>
                            <input type="text" name="sales" id="sales" value="{{ auth()->user()->username }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                {{ auth()->user()->role === 'sales' ? 'readonly' : '' }}>
                        </div>
                    </div>
                </div>

                <!-- Carrier Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Carrier Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="carrier" class="block text-sm font-medium text-gray-700">Carrier</label>
                            <input type="text" name="carrier" id="carrier"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="carrier_rate" class="block text-sm font-medium text-gray-700">Carrier Rate</label>
                            <input type="number" name="carrier_rate" id="carrier_rate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="dispatcher" class="block text-sm font-medium text-gray-700">Dispatcher</label>
                            <input type="text" name="dispatcher" id="dispatcher"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>
                    </div>
                </div>

                <!-- Pickup Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pickup Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="shipper_name" class="block text-sm font-medium text-gray-700">Shipper Name</label>
                            <input type="text" name="shipper_name" id="shipper_name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="shipper_address" class="block text-sm font-medium text-gray-700">Shipper
                                Address</label>
                            <input type="text" name="shipper_address" id="shipper_address"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="pu_date" class="block text-sm font-medium text-gray-700">Pickup Date</label>
                            <input type="date" name="pu_date" id="pu_date"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="po" class="block text-sm font-medium text-gray-700">PO Number</label>
                            <input type="text" name="po" id="po"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="pu_appt" class="block text-sm font-medium text-gray-700">Pickup Appointment</label>
                            <input type="text" name="pu_appt" id="pu_appt"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Delivery Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="receiver_name" class="block text-sm font-medium text-gray-700">Receiver
                                Name</label>
                            <input type="text" name="receiver_name" id="receiver_name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="receiver_address" class="block text-sm font-medium text-gray-700">Receiver
                                Address</label>
                            <input type="text" name="receiver_address" id="receiver_address"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="del_date" class="block text-sm font-medium text-gray-700">Delivery Date</label>
                            <input type="date" name="del_date" id="del_date"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="del" class="block text-sm font-medium text-gray-700">Delivery Number</label>
                            <input type="text" name="del" id="del"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label for="del_appt" class="block text-sm font-medium text-gray-700">Delivery
                                Appointment</label>
                            <input type="text" name="del_appt" id="del_appt"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-4"> <!-- Am înlocuit space-x cu gap-4 -->
                    <button type="button" onclick="window.location.href='{{ route('loads.index') }}'"
                        class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 border border-transparent rounded-md shadow-sm focus:outline-none">
                        {{ isset($load) ? 'Update Load' : 'Create Load' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
