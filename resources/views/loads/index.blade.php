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
            <div class="px-6 py-4 bg-gray-50">
                <form action="{{ route('loads.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label class="text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search loads..."
                                class="mt-1 w-full px-4 py-2 rounded-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <!-- Status Select -->
                        <div>
                            <label class="text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                class="mt-1 w-full px-4 py-2 rounded-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Statuses</option>
                                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                                <option value="dispatched" {{ request('status') === 'dispatched' ? 'selected' : '' }}>
                                    Dispatched</option>
                                <option value="in_transit" {{ request('status') === 'in_transit' ? 'selected' : '' }}>In
                                    Transit</option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="text-sm font-medium text-gray-700">Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="mt-1 w-full px-4 py-2 rounded-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="text-sm font-medium text-gray-700">Date To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="mt-1 w-full px-4 py-2 rounded-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3">
                        <a href="{{ route('loads.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Clear Filters
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                            Apply Filters
                        </button>
                    </div>
                </form>
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
                    <table class="min-w-full divide-y divide-gray-200">
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
                                    DEL Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($loads as $load)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer"
                                    ondblclick="window.location.href='{{ route('loads.edit', $load) }}'"
                                    data-load-id="{{ $load->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->load_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->customer }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->carrier }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->pu_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $load->del_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($load->status === 'new') bg-yellow-100 text-yellow-800
                                        @elseif($load->status === 'dispatched') bg-blue-100 text-blue-800
                                        @elseif($load->status === 'in_transit') bg-purple-100 text-purple-800
                                        @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($load->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('loads.edit', $load) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3 transition-colors duration-200">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        @if (auth()->user()->role === 'admin')
                                            <button type="button"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200 delete-load"
                                                data-load-id="{{ $load->id }}">
                                                <i class="fas fa-trash-alt mr-1"></i>Delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

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
            </div>
        `;
                document.body.appendChild(loadingOverlay);

                window.location.href = url;
            }
        </script>
    @endpush
@endsection
