@extends('layouts.app')

@section('title', isset($load) ? 'Edit Load' : 'Create Load')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header cu Load Number -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ isset($load) ? 'Edit Load' : 'Create Load' }}
                        </h1>
                        <div class="mt-2">
                            <span class="text-sm text-gray-500">Load #:</span>
                            <span class="ml-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                                {{ $load->load_number ?? 'Auto-generated' }}
                            </span>
                        </div>
                    </div>
                    @if (isset($load))
                        <div class="text-right">
                            <span
                                class="px-3 py-1 text-sm rounded-full {{ $load->status === 'New'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($load->status === 'Delivered'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $load->status }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Form -->
            <form action="{{ isset($load) ? route('loads.update', $load) : route('loads.store') }}" method="POST">
                @csrf
                @if (isset($load))
                    @method('PUT')
                @endif

                <!-- Grid pentru cele 4 secțiuni -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Load Info Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="mb-4 pb-2 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Load Information</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Sales -->
                                <div>
                                    <label for="sales" class="block text-sm font-medium text-gray-700">Sales*</label>
                                    <input type="text" id="sales" name="sales"
                                        value="{{ isset($load) ? $load->sales : Auth::user()->username }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        {{ auth()->user()->role !== 'admin' ? 'readonly' : '' }}>
                                </div>

                                <!-- Customer -->
                                <div>
                                    <label for="customer_search"
                                        class="block text-sm font-medium text-gray-700">Customer*</label>
                                    <div class="relative mt-1">
                                        <input type="text" id="customer_search" name="customer_search"
                                            value="{{ $load->customer ?? '' }}"
                                            class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Search or enter customer name...">
                                        <input type="hidden" id="customer" name="customer"
                                            value="{{ $load->customer ?? '' }}">
                                        <div id="customer_suggestions"
                                            class="absolute z-10 w-full bg-white shadow-lg rounded-md mt-1 hidden"></div>
                                    </div>
                                </div>

                                <!-- Customer Rate -->
                                <div>
                                    <label for="customer_rate" class="block text-sm font-medium text-gray-700">Customer
                                        Rate*</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="customer_rate" name="customer_rate"
                                            value="{{ $load->customer_rate ?? '' }}"
                                            class="block w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                </div>

                                <!-- Service -->
                                <div>
                                    <label for="service" class="block text-sm font-medium text-gray-700">Service*</label>
                                    <select id="service" name="service" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select Service</option>
                                        @foreach (['FTL', 'LTL', 'Flatbed', 'Power Only', 'Hotshot', 'Box Truck', 'Sprinter Van'] as $service)
                                            <option value="{{ $service }}"
                                                {{ isset($load) && $load->service == $service ? 'selected' : '' }}>
                                                {{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- PO Number -->
                                <div>
                                    <label for="po" class="block text-sm font-medium text-gray-700">PO</label>
                                    <input type="text" id="po" name="po" value="{{ $load->po ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                                    <select id="status" name="status" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @foreach (['New', 'Assigned', 'In Transit', 'Delivered'] as $status)
                                            <option value="{{ $status }}"
                                                {{ isset($load) && $load->status == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carrier Info Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="mb-4 pb-2 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Carrier Information</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Carrier -->
                                <div>
                                    <label for="carrier_search"
                                        class="block text-sm font-medium text-gray-700">Carrier</label>
                                    <div class="relative mt-1">
                                        <input type="text" id="carrier_search" name="carrier_search"
                                            value="{{ $load->carrier ?? '' }}"
                                            class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Search or enter carrier name...">
                                        <input type="hidden" id="carrier" name="carrier"
                                            value="{{ $load->carrier ?? '' }}">
                                        <div id="carrier_suggestions"
                                            class="absolute z-10 w-full bg-white shadow-lg rounded-md mt-1 hidden"></div>
                                    </div>
                                </div>

                                <!-- Carrier Rate -->
                                <div>
                                    <label for="carrier_rate" class="block text-sm font-medium text-gray-700">Carrier
                                        Rate</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="carrier_rate" name="carrier_rate"
                                            value="{{ $load->carrier_rate ?? '' }}"
                                            class="block w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                </div>

                                <!-- Dispatcher -->
                                <div>
                                    <label for="dispatcher"
                                        class="block text-sm font-medium text-gray-700">Dispatcher</label>
                                    <input type="text" id="dispatcher" name="dispatcher"
                                        value="{{ $load->dispatcher ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        {{ auth()->user()->role !== 'admin' && auth()->user()->role !== 'ops' ? 'readonly' : '' }}>
                                </div>

                                <!-- Equipment Type -->
                                <div>
                                    <label for="equipment_type" class="block text-sm font-medium text-gray-700">Equipment
                                        Type</label>
                                    <select id="equipment_type" name="equipment_type"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select Equipment</option>
                                        <option value="Dry Van"
                                            {{ isset($load) && $load->equipment_type == 'Dry Van' ? 'selected' : '' }}>
                                            Dry Van</option>
                                        <option value="Reefer"
                                            {{ isset($load) && $load->equipment_type == 'Reefer' ? 'selected' : '' }}>
                                            Reefer</option>
                                        <option value="Flatbed"
                                            {{ isset($load) && $load->equipment_type == 'Flatbed' ? 'selected' : '' }}>
                                            Flatbed</option>
                                        <option value="Step Deck"
                                            {{ isset($load) && $load->equipment_type == 'Step Deck' ? 'selected' : '' }}>
                                            Step Deck</option>
                                    </select>
                                </div>

                                <!-- Driver Contact -->
                                <div>
                                    <label for="driver_contact" class="block text-sm font-medium text-gray-700">Driver
                                        Contact</label>
                                    <input type="text" id="driver_contact" name="driver_contact"
                                        value="{{ $load->driver_contact ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Enter driver's phone number">
                                </div>

                                <!-- Driver Name -->
                                <div>
                                    <label for="driver_name" class="block text-sm font-medium text-gray-700">Driver
                                        Name</label>
                                    <input type="text" id="driver_name" name="driver_name"
                                        value="{{ $load->driver_name ?? '' }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Enter driver's name">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Shipper Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="mb-4 pb-2 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Shipper Information</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Shipper Name and Search -->
                                <div class="space-y-1">
                                    <div class="flex justify-between items-center">
                                        <label for="shipper_name" class="block text-sm font-medium text-gray-700">Shipper
                                            Name</label>
                                        <div class="flex space-x-2">
                                            <button type="button" data-modal-target="locationModal"
                                                data-location-type="shipper" data-action="create"
                                                class="text-sm text-blue-600 hover:text-blue-700">
                                                <i class="fas fa-plus-circle mr-1"></i>Add New
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1 relative">
                                        <input type="text" id="shipper_search" placeholder="Search locations..."
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            autocomplete="off">
                                        <input type="hidden" id="shipper_id" name="shipper_id">
                                        <div id="shipper_suggestions"
                                            class="absolute z-10 w-full bg-white shadow-lg rounded-md mt-1 hidden max-h-60 overflow-y-auto">
                                        </div>
                                    </div>

                                    <!-- Shipper Details Card -->
                                    <div id="shipper_details"
                                        class="mt-3 p-4 border border-gray-200 rounded-lg bg-gray-50 hidden">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 id="selected_shipper_name" class="font-medium text-gray-900"></h4>
                                                <p id="selected_shipper_address" class="text-sm text-gray-600 mt-1"></p>
                                                <p id="selected_shipper_notes" class="text-sm text-gray-500 mt-1 italic">
                                                </p>
                                            </div>
                                            <button type="button" data-modal-target="locationModal"
                                                data-location-type="shipper" data-action="edit"
                                                class="text-sm text-blue-600 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pickup Date -->
                                <div>
                                    <label for="pu_date" class="block text-sm font-medium text-gray-700">Pickup
                                        Date*</label>
                                    <input type="date" id="pu_date" name="pu_date" required
                                        value="{{ $load->pu_date ?? '' }}"
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>

                                <!-- Pickup Appointment -->
                                <div>
                                    <label for="pu_appt" class="block text-sm font-medium text-gray-700">Pickup
                                        Appointment</label>
                                    <input type="text" id="pu_appt" name="pu_appt"
                                        value="{{ $load->pu_appt ?? '' }}"
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter appointment time">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Receiver Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="mb-4 pb-2 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Receiver Information</h2>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Receiver Name and Search -->
                                <div class="space-y-1">
                                    <div class="flex justify-between items-center">
                                        <label for="receiver_name"
                                            class="block text-sm font-medium text-gray-700">Receiver Name</label>
                                        <div class="flex space-x-2">
                                            <button type="button" data-modal-target="locationModal"
                                                data-location-type="receiver" data-action="create"
                                                class="text-sm text-blue-600 hover:text-blue-700">
                                                <i class="fas fa-plus-circle mr-1"></i>Add New
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1 relative">
                                        <input type="text" id="receiver_search" placeholder="Search locations..."
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            autocomplete="off">
                                        <input type="hidden" id="receiver_id" name="receiver_id">
                                        <div id="receiver_suggestions"
                                            class="absolute z-10 w-full bg-white shadow-lg rounded-md mt-1 hidden max-h-60 overflow-y-auto">
                                        </div>
                                    </div>

                                    <!-- Receiver Details Card -->
                                    <div id="receiver_details"
                                        class="mt-3 p-4 border border-gray-200 rounded-lg bg-gray-50 hidden">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 id="selected_receiver_name" class="font-medium text-gray-900"></h4>
                                                <p id="selected_receiver_address" class="text-sm text-gray-600 mt-1"></p>
                                                <p id="selected_receiver_notes" class="text-sm text-gray-500 mt-1 italic">
                                                </p>
                                            </div>
                                            <button type="button" data-modal-target="locationModal"
                                                data-location-type="receiver" data-action="edit"
                                                class="text-sm text-blue-600 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delivery Date -->
                                <div>
                                    <label for="del_date" class="block text-sm font-medium text-gray-700">Delivery
                                        Date*</label>
                                    <input type="date" id="del_date" name="del_date" required
                                        value="{{ $load->del_date ?? '' }}"
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>

                                <!-- Delivery Appointment -->
                                <div>
                                    <label for="del_appt" class="block text-sm font-medium text-gray-700">Delivery
                                        Appointment</label>
                                    <input type="text" id="del_appt" name="del_appt"
                                        value="{{ $load->del_appt ?? '' }}"
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter appointment time">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Action Buttons -->
                    <div class="mt-6 bg-gray-50 px-6 py-4 flex items-center justify-end space-x-4 rounded-lg">
                        <a href="{{ route('loads.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ isset($load) ? 'M5 13l4 4L19 7' : 'M12 6v6m0 0v6m0-6h6m-6 0H6' }}" />
                            </svg>
                            {{ isset($load) ? 'Update Load' : 'Create Load' }}
                        </button>
                    </div>
            </form>
        </div>
    </div>


    <!-- Location Modal -->
    <div id="locationModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="locationForm" class="p-6">
                    @csrf
                    <input type="hidden" id="locationType" name="locationType" value="">
                    <input type="hidden" id="locationId" name="locationId" value="">
                    <input type="hidden" id="formAction" name="formAction" value="create">

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">Add New Location</h3>
                        <div id="deleteLocationBtn" class="hidden">
                            <button type="button" class="text-red-600 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div id="formErrorAlert" class="mb-4 bg-red-50 text-red-600 p-4 rounded-md hidden"></div>

                    <div class="space-y-4">
                        <div>
                            <label for="facility_name" class="block text-sm font-medium text-gray-700">Facility
                                Name</label>
                            <input type="text" name="facility_name" id="facility_name" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" id="address" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 flex space-x-3">
                        <button type="button" id="cancelLocation"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                            Save Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('locationModal');
                const form = document.getElementById('locationForm');
                const locationTypeInput = document.getElementById('locationType');
                const locationIdInput = document.getElementById('locationId');
                const formActionInput = document.getElementById('formAction');
                const modalTitle = document.getElementById('modal-title');
                const deleteBtn = document.getElementById('deleteLocationBtn');
                const errorAlert = document.getElementById('formErrorAlert');

                // Function to handle location search
                async function searchLocations(searchTerm, type) {
                    try {
                        const response = await fetch(`/locations/search?query=${encodeURIComponent(searchTerm)}`);
                        const locations = await response.json();
                        return locations;
                    } catch (error) {
                        console.error('Error searching locations:', error);
                        return [];
                    }
                }

                // Setup location search for both shipper and receiver
                ['shipper', 'receiver'].forEach(type => {
                    const searchInput = document.getElementById(`${type}_search`);
                    const suggestionsDiv = document.getElementById(`${type}_suggestions`);
                    const detailsDiv = document.getElementById(`${type}_details`);

                    let searchTimeout;

                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        const query = this.value.trim();

                        if (query.length < 2) {
                            suggestionsDiv.classList.add('hidden');
                            return;
                        }

                        searchTimeout = setTimeout(async () => {
                            const locations = await searchLocations(query);
                            suggestionsDiv.innerHTML = '';

                            if (locations.length > 0) {
                                locations.forEach(location => {
                                    const div = document.createElement('div');
                                    div.className =
                                        'p-2 hover:bg-gray-100 cursor-pointer';
                                    div.innerHTML = `
                            <div class="font-medium">${location.facility_name}</div>
                            <div class="text-sm text-gray-600">${location.address}</div>
                        `;
                                    div.addEventListener('click', () => {
                                        selectLocation(location, type);
                                        suggestionsDiv.classList.add(
                                            'hidden');
                                    });
                                    suggestionsDiv.appendChild(div);
                                });
                                suggestionsDiv.classList.remove('hidden');
                            } else {
                                suggestionsDiv.classList.add('hidden');
                            }
                        }, 300);
                    });

                    // Hide suggestions when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                            suggestionsDiv.classList.add('hidden');
                        }
                    });
                });

                // Function to select a location
                function selectLocation(location, type) {
                    const detailsDiv = document.getElementById(`${type}_details`);
                    const searchInput = document.getElementById(`${type}_search`);
                    const idInput = document.getElementById(`${type}_id`);

                    document.getElementById(`selected_${type}_name`).textContent = location.facility_name;
                    document.getElementById(`selected_${type}_address`).textContent = location.address;
                    document.getElementById(`selected_${type}_notes`).textContent = location.notes || '';

                    searchInput.value = location.facility_name;
                    idInput.value = location.id;
                    detailsDiv.classList.remove('hidden');
                }

                // Open modal handler
                document.querySelectorAll('[data-modal-target="locationModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const locationType = this.getAttribute('data-location-type');
                        const action = this.getAttribute('data-action');
                        locationTypeInput.value = locationType;
                        formActionInput.value = action;

                        if (action === 'edit') {
                            const locationId = document.getElementById(`${locationType}_id`).value;
                            if (!locationId) return;

                            loadLocationForEdit(locationId);
                            modalTitle.textContent = 'Edit Location';
                            deleteBtn.classList.remove('hidden');
                        } else {
                            modalTitle.textContent = 'Add New Location';
                            form.reset();
                            deleteBtn.classList.add('hidden');
                        }

                        modal.classList.remove('hidden');
                    });
                });

                // Load location for editing
                async function loadLocationForEdit(locationId) {
                    try {
                        console.log('Loading location with ID:', locationId);

                        const response = await fetch(`/locations/${locationId}`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();
                        console.log('Response data:', data);

                        if (data.success) {
                            document.getElementById('facility_name').value = data.location.facility_name;
                            document.getElementById('address').value = data.location.address;
                            document.getElementById('notes').value = data.location.notes || '';
                            document.getElementById('locationId').value = data.location.id;
                            errorAlert.classList.add('hidden');
                        } else {
                            throw new Error(data.message || 'Failed to load location data');
                        }
                    } catch (error) {
                        console.error('Error loading location:', error);
                        errorAlert.textContent = error.message;
                        errorAlert.classList.remove('hidden');
                    }
                }

                // Modificăm handler-ul pentru deschiderea modalului
                document.querySelectorAll('[data-modal-target="locationModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const locationType = this.getAttribute('data-location-type');
                        const action = this.getAttribute('data-action');
                        locationTypeInput.value = locationType;
                        formActionInput.value = action;

                        if (action === 'edit') {
                            // Găsim ID-ul locației selectate
                            const locationId = document.getElementById(`${locationType}_id`).value;
                            if (!locationId) {
                                errorAlert.textContent = 'Please select a location first';
                                errorAlert.classList.remove('hidden');
                                return;
                            }

                            loadLocationForEdit(locationId);
                            modalTitle.textContent = 'Edit Location';
                            deleteBtn.classList.remove('hidden');
                        } else {
                            modalTitle.textContent = 'Add New Location';
                            form.reset();
                            deleteBtn.classList.add('hidden');
                        }

                        modal.classList.remove('hidden');
                    });
                });

                // Modificăm funcția de selectare a locației pentru a salva ID-ul
                function selectLocation(location, type) {
                    const detailsDiv = document.getElementById(`${type}_details`);
                    const searchInput = document.getElementById(`${type}_search`);
                    const idInput = document.getElementById(`${type}_id`);

                    document.getElementById(`selected_${type}_name`).textContent = location.facility_name;
                    document.getElementById(`selected_${type}_address`).textContent = location.address;
                    if (location.notes) {
                        document.getElementById(`selected_${type}_notes`).textContent = location.notes;
                        document.getElementById(`selected_${type}_notes`).classList.remove('hidden');
                    } else {
                        document.getElementById(`selected_${type}_notes`).classList.add('hidden');
                    }

                    searchInput.value = location.facility_name;
                    idInput.value = location.id; // Salvăm ID-ul locației
                    detailsDiv.classList.remove('hidden');
                }

                // Modificăm handler-ul pentru submit-ul formularului
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    errorAlert.classList.add('hidden');

                    const formData = {
                        facility_name: document.getElementById('facility_name').value,
                        address: document.getElementById('address').value,
                        notes: document.getElementById('notes').value
                    };

                    try {
                        const locationId = document.getElementById('locationId').value;
                        const isEdit = formActionInput.value === 'edit';

                        const url = isEdit ? `/locations/${locationId}` : '/locations';
                        const method = isEdit ? 'PUT' : 'POST';

                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify(formData)
                        });

                        const data = await response.json();

                        if (data.success) {
                            const type = locationTypeInput.value;
                            selectLocation(data.location, type);
                            modal.classList.add('hidden');
                            form.reset();
                            // Adăugăm un mesaj de succes temporar
                            const successMessage = document.createElement('div');
                            successMessage.className =
                                'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                            successMessage.textContent = isEdit ? 'Location updated successfully' :
                                'Location created successfully';
                            document.body.appendChild(successMessage);
                            setTimeout(() => successMessage.remove(), 3000);
                        } else {
                            throw new Error(data.message || 'Failed to save location');
                        }
                    } catch (error) {
                        errorAlert.textContent = error.message;
                        errorAlert.classList.remove('hidden');
                    }
                });

                // Delete location handler
                deleteBtn.addEventListener('click', async function() {
                    if (!confirm('Are you sure you want to delete this location?')) return;

                    try {
                        const response = await fetch(`/locations/${locationIdInput.value}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            const type = locationTypeInput.value;
                            document.getElementById(`${type}_search`).value = '';
                            document.getElementById(`${type}_id`).value = '';
                            document.getElementById(`${type}_details`).classList.add('hidden');
                            modal.classList.add('hidden');
                            form.reset();
                        } else {
                            throw new Error(data.message || 'Failed to delete location');
                        }
                    } catch (error) {
                        errorAlert.textContent = error.message;
                        errorAlert.classList.remove('hidden');
                    }
                });

                // Cancel button handler
                document.getElementById('cancelLocation').addEventListener('click', function() {
                    modal.classList.add('hidden');
                    form.reset();
                    errorAlert.classList.add('hidden');
                });

                // Close modal when clicking outside
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        form.reset();
                        errorAlert.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function setupAutocomplete(searchInputId, hiddenInputId, suggestionsId, data) {
                    const searchInput = document.getElementById(searchInputId);
                    const hiddenInput = document.getElementById(hiddenInputId);
                    const suggestions = document.getElementById(suggestionsId);

                    searchInput.addEventListener('input', function() {
                        const value = this.value.toLowerCase();
                        const matches = data.filter(item => item.name.toLowerCase().includes(value));

                        suggestions.innerHTML = '';
                        suggestions.classList.remove('hidden');

                        matches.forEach(item => {
                            const div = document.createElement('div');
                            div.textContent = item.name;
                            div.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer');
                            div.addEventListener('click', function() {
                                searchInput.value = item.name;
                                hiddenInput.value = item.name;
                                suggestions.classList.add('hidden');
                            });
                            suggestions.appendChild(div);
                        });

                        if (matches.length === 0) {
                            suggestions.classList.add('hidden');
                        }
                    });

                    searchInput.addEventListener('change', function() {
                        hiddenInput.value = this.value;
                    });

                    document.addEventListener('click', function(e) {
                        if (e.target !== searchInput && e.target !== suggestions) {
                            suggestions.classList.add('hidden');
                        }
                    });
                }

                const customers = @json($customers ?? []);
                const carriers = @json($carriers ?? []);

                setupAutocomplete('customer_search', 'customer', 'customer_suggestions', customers);
                setupAutocomplete('carrier_search', 'carrier', 'carrier_suggestions', carriers);
            });
        </script>
    @endpush
@endsection
