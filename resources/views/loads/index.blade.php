@extends('layouts.app')

@section('title', 'Loads')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Loads</h2>
                @if (auth()->user()->role === 'sales' || auth()->user()->role === 'csr' || auth()->user()->role === 'admin')
                    <a href="{{ route('loads.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>Create New Load
                    </a>
                @endif
            </div>

            <!-- Search and Filters -->
            <div class="bg-white rounded-lg shadow-lg mb-6 overflow-hidden">
                <div class="px-6 py-4 bg-blue-50 border-b border-blue-100 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-filter text-blue-600"></i>
                        <h3 class="font-semibold text-blue-800">Advanced Filters</h3>
                    </div>
                    <button type="button" id="toggleFilters" class="text-blue-600 hover:text-blue-800 text-sm">
                        <span class="hide-filters hidden">Show Filters</span>
                        <span class="show-filters">Hide Filters</span>
                    </button>
                </div>

                <div id="filterSection" class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('loads.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search Field -->
                            <div class="space-y-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">
                                    Search Load/Customer/Carrier
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Search...">
                                </div>
                            </div>

                            <!-- Status Field -->
                            <div class="space-y-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select name="status" id="status"
                                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Statuses</option>
                                    <option value="new" {{ request('status') === 'New' ? 'selected' : '' }}>New</option>
                                    <option value="dispatched" {{ request('status') === 'Dispatched' ? 'selected' : '' }}>
                                        Dispatched</option>
                                    <option value="In transit" {{ request('status') === 'In transit' ? 'selected' : '' }}>In
                                        transit</option>
                                    <option value="delivered" {{ request('status') === 'Delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                </select>
                            </div>

                            <!-- Date From Field -->
                            <div class="space-y-1">
                                <label for="date_from" class="block text-sm font-medium text-gray-700">
                                    Date From
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <!-- Date To Field -->
                            <div class="space-y-1">
                                <label for="date_to" class="block text-sm font-medium text-gray-700">
                                    Date To
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <!-- Applied Filters Tags -->
                            <div class="flex-1 flex items-center space-x-2">
                                @if (request('search') || request('status') || request('date_from') || request('date_to'))
                                    <span class="text-sm text-gray-600">Active filters:</span>
                                    @if (request('search'))
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Search: {{ request('search') }}
                                            <a href="{{ route('loads.index', request()->except('search')) }}"
                                                class="ml-1 text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                    {{-- Similar tags for other active filters --}}
                                @endif
                            </div>

                            <a href="{{ route('loads.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-times mr-2"></i>
                                Clear Filters
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                <i class="fas fa-search mr-2"></i>
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loads Table -->
            <div class="overflow-x-auto">
                @if ($loads->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No loads found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're
                            looking for.</p>
                        <div class="mt-6">
                            <a href="{{ route('loads.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Clear all filters
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Desktop View - vizibil doar pe ecrane md și mai mari --}}
                    <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Load #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Carrier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    PU Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Del Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($loads as $load)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->load_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->customer }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->carrier }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->pu_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->del_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if ($load->status === 'New') bg-blue-100 text-blue-800
                            @elseif($load->status === 'Dispatched') bg-yellow-100 text-yellow-800
                            @elseif($load->status === 'In transit') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($load->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('loads.edit', $load) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if (auth()->user()->role === 'admin')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-load"
                                                data-load-id="{{ $load->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Mobile View - vizibil doar pe ecrane mai mici decât md --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($loads as $load)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-4 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Load #</span>
                                            <p class="text-lg font-bold text-gray-900">{{ $load->load_number }}</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                            @if ($load->status === 'New') bg-blue-100 text-blue-800
                            @elseif($load->status === 'Dispatched') bg-yellow-100 text-yellow-800
                            @elseif($load->status === 'In transit') bg-purple-100 text-purple-800
                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($load->status) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Customer</span>
                                            <p class="text-gray-900">{{ $load->customer }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Carrier</span>
                                            <p class="text-gray-900">{{ $load->carrier ?: 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">PU Date</span>
                                            <p class="text-gray-900">{{ $load->pu_date }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Del Date</span>
                                            <p class="text-gray-900">{{ $load->del_date }}</p>
                                        </div>
                                    </div>

                                    <div class="pt-3 border-t border-gray-200 flex justify-end space-x-3">
                                        <a href="{{ route('loads.edit', $load) }}"
                                            class="inline-flex items-center px-3 py-1 border border-blue-600 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        @if (auth()->user()->role === 'admin')
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1 border border-red-600 rounded-md text-sm font-medium text-red-600 hover:bg-red-50 delete-load"
                                                data-load-id="{{ $load->id }}">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Delete
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
            @endif


            <div class="mt-4">
                {{ $loads->links() }}
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Load
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this load? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmDelete"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" id="cancelDelete"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteModal = document.getElementById('deleteModal');
                const confirmDeleteBtn = document.getElementById('confirmDelete');
                const cancelDeleteBtn = document.getElementById('cancelDelete');
                let loadIdToDelete = null;

                // Funcție pentru a afișa modalul
                function showModal() {
                    deleteModal.classList.remove('hidden');
                }

                // Funcție pentru a ascunde modalul
                function hideModal() {
                    deleteModal.classList.add('hidden');
                }

                // Event listener pentru butoanele de ștergere
                document.querySelectorAll('.delete-load').forEach(button => {
                    button.addEventListener('click', function() {
                        loadIdToDelete = this.getAttribute('data-load-id');
                        showModal();
                    });
                });

                // Event listener pentru butonul de anulare
                cancelDeleteBtn.addEventListener('click', hideModal);

                // Event listener pentru butonul de confirmare
                confirmDeleteBtn.addEventListener('click', function() {
                    if (loadIdToDelete) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/loads/${loadIdToDelete}`;
                        form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });

                // Restul codului pentru double click și hover...
                const rows = document.querySelectorAll('tr[data-load-id]');

                rows.forEach(row => {
                    row.addEventListener('mouseover', function() {
                        this.title = 'Double click to edit';
                    });

                    const actionButtons = row.querySelector('td:last-child');
                    if (actionButtons) {
                        actionButtons.addEventListener('dblclick', function(e) {
                            e.stopPropagation();
                        });
                    }
                });
            });

            function navigateToEdit(url) {
                const loadingOverlay = document.createElement('div');
                loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loadingOverlay.innerHTML = `
            <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
                <svg class="animate-spin h-5 w-5 mr-3 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3 -2.647z"></path>
                </svg>
                <span class="text-gray-700">Loading...</span>
            </div>`;
                document.body.appendChild(loadingOverlay);

                window.location.href = url;
            }

            const toggleButton = document.getElementById('toggleFilters');
            const filterSection = document.getElementById('filterSection');
            const showText = document.querySelector('.show-filters');
            const hideText = document.querySelector('.hide-filters');

            // Check local storage for filter state
            const filterVisible = localStorage.getItem('filterVisible') !== 'false';
            if (!filterVisible) {
                filterSection.classList.add('hidden');
                showText.classList.remove('hidden');
                hideText.classList.add('hidden');
            }

            toggleButton.addEventListener('click', function() {
                filterSection.classList.toggle('hidden');
                showText.classList.toggle('hidden');
                hideText.classList.toggle('hidden');

                // Save state to local storage
                localStorage.setItem('filterVisible', filterSection.classList.contains('hidden') ? 'false' : 'true');
            });
        </script>
    @endpush
@endsection
