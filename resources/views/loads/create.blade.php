@extends('layouts.app')

@section('title', isset($load) ? 'Edit Load' : 'Create Load')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h2 class="text-2xl font-bold mb-6">{{ isset($load) ? 'Edit Load' : 'Create Load' }}</h2>

        <form action="{{ isset($load) ? route('loads.update', $load) : route('loads.store') }}" method="POST">
            @csrf
            @if (isset($load))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Load Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium mb-4">Load Info</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Load #</label>
                            <input type="text" disabled value="{{ $load->load_number ?? 'Will be generated' }}"
                                class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sales Rep</label>
                            <input type="text" name="sales" value="{{ $load->sales ?? auth()->user()->username }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                {{ auth()->user()->role !== 'admin' ? 'readonly' : '' }}>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dispatcher</label>
                            <input type="text" name="dispatcher" value="{{ $load->dispatcher ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                                {{ auth()->user()->role !== 'admin' && auth()->user()->role !== 'ops' ? 'readonly' : '' }}>
                        </div>
                        <!-- În view pentru client/costumer -->
                        <div>
                            <label class="text-sm font-medium text-gray-700">Client</label>
                            <div class="relative">
                                <input type="text" id="costumer-input" name="name" value="{{ old('name') }}"
                                    placeholder="Search client..."
                                    class="w-full border border-gray-300 rounded-md px-3 py-2">

                                <!-- Dropdown pentru rezultate -->
                                <div id="costumer-dropdown"
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rate</label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="costumer_rate" value="{{ $load->costumer_rate ?? '' }}"
                                    class="pl-7 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carrier Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium mb-4">Carrier</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Carrier Name</label>
                            <div class="relative">
                                <input type="text" id="carrier-input" name="carrier" placeholder="Search carrier..."
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                                <div id="carrier-dropdown"
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rate</label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="carrier_rate" id="carrier-rate"
                                    class="pl-7 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Service Type</label>
                            <input type="text" name="service" id="carrier-service"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="carrier-notes" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Shipper Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium mb-4">Shipper</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facility Name</label>
                            <div class="relative">
                                <div class="flex gap-2">
                                    <input type="text" id="shipper-input" placeholder="Search shipper..."
                                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <button type="button" onclick="openLocationModal('shipper')"
                                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="editLocation('shipper')"
                                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>

                                <div id="shipper-dropdown"
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                </div>
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="shipper-address" name="shipper_address"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></input>
                                <div id="shipper-dropdown"
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">PU Date</label>
                                <input type="date" name="pu_date" value="{{ $load->pu_date ?? '' }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">PO #</label>
                                <input type="text" name="po" value="{{ $load->po ?? '' }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Appointment</label>
                            <input type="text" name="pu_appt" value="{{ $load->pu_appt ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pickup_type" value="fcfs" class="form-radio"
                                    {{ isset($load) && $load->pickup_type === 'fcfs' ? 'checked' : '' }}>
                                <span class="ml-2">FCFS</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pickup_type" value="by_appt" class="form-radio"
                                    {{ isset($load) && $load->pickup_type === 'by_appt' ? 'checked' : '' }}>
                                <span class="ml-2">By Appt.</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Receiver Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium mb-4">Receiver</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facility Name</label>
                            <div class="relative">
                                <div class="flex gap-2">
                                    <input type="text" id="receiver-input" placeholder="Search receiver..."
                                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <button type="button" onclick="openLocationModal('receiver')"
                                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="editLocation('receiver')"
                                        class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>

                                <div id="receiver-dropdown"
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                </div>
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="receiver-address" name="receiver_address"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></input>
                                <div id="receiver-dropdown"
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DEL Date</label>
                                <input type="date" name="del_date" value="{{ $load->del_date ?? '' }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DEL #</label>
                                <input type="text" name="del" value="{{ $load->del ?? '' }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Appointment</label>
                            <input type="text" name="del_appt" value="{{ $load->del_appt ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="delivery_type" value="fcfs" class="form-radio"
                                    {{ isset($load) && $load->delivery_type === 'fcfs' ? 'checked' : '' }}>
                                <span class="ml-2">FCFS</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="delivery_type" value="by_appt" class="form-radio"
                                    {{ isset($load) && $load->delivery_type === 'by_appt' ? 'checked' : '' }}>
                                <span class="ml-2">By Appt.</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" onclick="window.location.href='{{ route('loads.index') }}'"
                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Clear
                </button>
                <button type="submit"
                    class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ isset($load) ? 'Update Load' : 'Save Load' }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carrierInput = document.getElementById('carrier-input');
                const carrierDropdown = document.getElementById('carrier-dropdown');
                let currentCarrier = null;

                const searchCarriers = debounce(async function(query) {
                    if (query.length < 2) {
                        carrierDropdown.classList.add('hidden');
                        return;
                    }

                    try {
                        const response = await fetch(`/search/carriers?query=${encodeURIComponent(query)}`);
                        const carriers = await response.json();

                        carrierDropdown.innerHTML = '';

                        if (carriers.length === 0) {
                            carrierDropdown.classList.add('hidden');
                            return;
                        }

                        carriers.forEach(carrier => {
                            const div = document.createElement('div');
                            div.className = 'p-2 hover:bg-gray-100 cursor-pointer';

                            // Afișăm informații relevante în dropdown
                            const displayText = carrier.mc ?
                                `${carrier.name} (MC: ${carrier.mc})` :
                                carrier.name;

                            div.textContent = displayText;
                            div.addEventListener('click', () => {
                                currentCarrier = carrier;
                                carrierInput.value = carrier.name;

                                // Populăm restul câmpurilor
                                if (document.getElementById('carrier-mc')) {
                                    document.getElementById('carrier-mc').value = carrier
                                        .mc || '';
                                }
                                if (document.getElementById('carrier-contact')) {
                                    document.getElementById('carrier-contact').value =
                                        carrier.contact_name || '';
                                }
                                if (document.getElementById('carrier-phone')) {
                                    document.getElementById('carrier-phone').value = carrier
                                        .phone || '';
                                }
                                if (document.getElementById('carrier-email')) {
                                    document.getElementById('carrier-email').value = carrier
                                        .email || '';
                                }
                                if (document.getElementById('carrier-notes')) {
                                    document.getElementById('carrier-notes').value = carrier
                                        .notes || '';
                                }

                                carrierDropdown.classList.add('hidden');
                            });
                            carrierDropdown.appendChild(div);
                        });

                        carrierDropdown.classList.remove('hidden');
                    } catch (error) {
                        console.error('Error searching carriers:', error);
                    }
                }, 300);

                carrierInput.addEventListener('input', (e) => {
                    searchCarriers(e.target.value);
                });

                // Închide dropdown-ul când se face click în afara lui
                document.addEventListener('click', function(e) {
                    if (!carrierInput.contains(e.target) && !carrierDropdown.contains(e.target)) {
                        carrierDropdown.classList.add('hidden');
                    }
                });

                // Resetare câmpuri când se șterge carrier-ul
                carrierInput.addEventListener('change', function(e) {
                    if (!e.target.value) {
                        currentCarrier = null;
                        // Resetăm toate câmpurile
                        ['mc', 'contact', 'phone', 'email', 'notes'].forEach(field => {
                            const element = document.getElementById(`carrier-${field}`);
                            if (element) element.value = '';
                        });
                    }
                });
            });
        </script>
        <script>
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            document.addEventListener('DOMContentLoaded', function() {
                const costumerInput = document.getElementById('costumer-input');
                const costumerDropdown = document.getElementById('costumer-dropdown');

                const searchCostumers = debounce(function(query) {
                    if (query.length < 2) {
                        costumerDropdown.classList.add('hidden');
                        return;
                    }

                    fetch(`/search/costumers?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Received data:', data); // Pentru debug
                            costumerDropdown.innerHTML = '';

                            if (data.length === 0) {
                                costumerDropdown.classList.add('hidden');
                                return;
                            }

                            data.forEach(costumer => {
                                const div = document.createElement('div');
                                div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                                div.textContent = costumer.name;
                                div.addEventListener('click', () => {
                                    costumerInput.value = costumer.name;
                                    costumerDropdown.classList.add('hidden');
                                });
                                costumerDropdown.appendChild(div);
                            });

                            costumerDropdown.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }, 300);

                costumerInput.addEventListener('input', (e) => {
                    searchCostumers(e.target.value);
                });

                // Închide dropdown-ul când se face click în afara lui
                document.addEventListener('click', function(e) {
                    if (!costumerInput.contains(e.target) && !costumerDropdown.contains(e.target)) {
                        costumerDropdown.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush


    <!-- La sfârșitul view-ului -->
    <form id="location-form" class="mt-2 space-y-6">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="location-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">Add Location</h3>
                    <form id="location-form" class="mt-2 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facility Name</label>
                            <input type="text" id="modal-facility-name" name="facility_name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="modal-address" name="address" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="modal-notes" name="notes" rows="2"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                        </div>

                        <div class="mt-4 flex justify-end gap-4">
                            <button type="button" onclick="closeLocationModal()"
                                class="bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 border border-transparent rounded-md shadow-sm focus:outline-none">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>


    @push('scripts')
        <script>
            let currentLocationId = null;
            let currentLocationType = null; // 'shipper' sau 'receiver'

            function closeLocationModal() {
                document.getElementById('location-modal').classList.add('hidden');
            }

            // Modifică event listener-ul formularului pentru a gestiona corect atât crearea cât și editarea
            document.getElementById('location-form').addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    const formData = new URLSearchParams();
                    formData.append('facility_name', document.getElementById('modal-facility-name').value);
                    formData.append('address', document.getElementById('modal-address').value);
                    formData.append('notes', document.getElementById('modal-notes').value || '');
                    formData.append('_token', document.querySelector('input[name="_token"]').value);

                    let url = '/locations'; // URL implicit pentru creare
                    let method = 'POST'; // Metoda implicită pentru creare

                    // Dacă avem un ID, atunci este un update
                    if (currentLocationId) {
                        url = `/locations/${currentLocationId}`;
                        formData.append('_method', 'PUT');
                    }

                    console.log('Request URL:', url); // Pentru debugging
                    console.log('Request Method:', method); // Pentru debugging

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Error saving location');
                    }

                    const data = await response.json();

                    if (data.success && data.location) {
                        // Actualizează câmpurile în formular
                        const input = document.getElementById(`${currentLocationType}-input`);
                        const address = document.getElementById(`${currentLocationType}-address`);

                        input.value = data.location.facility_name;
                        address.value = data.location.address;

                        closeLocationModal();
                    } else {
                        throw new Error('Invalid response format');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message || 'There was an error saving the location');
                }
            });

            // Funcție pentru deschiderea modalului
            function openLocationModal(type) {
                currentLocationType = type;
                currentLocationId = null; // Resetăm ID-ul când deschidem modalul pentru o locație nouă

                // Resetăm formularul
                document.getElementById('location-form').reset();

                // Actualizăm titlul
                document.getElementById('modal-title').textContent = 'Add Location';

                // Afișăm modalul
                document.getElementById('location-modal').classList.remove('hidden');
            }

            // Funcție pentru editarea unei locații existente
            function editLocation(type) {
                const input = document.getElementById(`${type}-input`);
                if (!input.value) {
                    alert('Please select a location first');
                    return;
                }

                fetch(`/locations/search?query=${encodeURIComponent(input.value)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const location = data[0];
                            currentLocationId = location.id;
                            currentLocationType = type;

                            // Populăm modalul cu datele locației
                            document.getElementById('modal-facility-name').value = location.facility_name;
                            document.getElementById('modal-address').value = location.address;
                            document.getElementById('modal-notes').value = location.notes || '';

                            // Actualizăm titlul
                            document.getElementById('modal-title').textContent = 'Edit Location';

                            // Afișăm modalul
                            document.getElementById('location-modal').classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error loading location details');
                    });
            }

            // Inițializare căutare pentru shipper și receiver
            function initializeLocationSearch(type) {
                const input = document.getElementById(`${type}-input`);
                const dropdown = document.getElementById(`${type}-dropdown`);
                const address = document.getElementById(`${type}-address`);

                input.addEventListener('input', debounce(function(e) {
                    const query = e.target.value;

                    if (query.length < 2) {
                        dropdown.classList.add('hidden');
                        return;
                    }

                    fetch(`/locations/search?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            dropdown.innerHTML = '';

                            data.forEach(location => {
                                const div = document.createElement('div');
                                div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                                div.textContent = location.facility_name;
                                div.addEventListener('click', () => {
                                    input.value = location.facility_name;
                                    address.value = location.address;
                                    dropdown.classList.add('hidden');
                                });
                                dropdown.appendChild(div);
                            });

                            if (data.length > 0) {
                                dropdown.classList.remove('hidden');
                            }
                        });
                }, 300));
            }

            initializeLocationSearch('shipper');
            initializeLocationSearch('receiver');
        </script>
    @endpush
@endsection
