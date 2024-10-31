@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Customers</h2>
                <a href="{{ route('costumers.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Add New Customer
                </a>
            </div>

            <!-- Search -->
            <div class="px-6 py-4 bg-gray-50">
                <form action="{{ route('costumers.index') }}" method="GET">
                    <div class="flex">
                        <input type="text" name="search" placeholder="Search customers..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 rounded-l-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition duration-300 ease-in-out">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customers Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Credit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($costumers as $costumer)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->contact_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $costumer->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ number_format($costumer->credit, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($costumer->status === 'active') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($costumer->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('costumers.edit', $costumer) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-4">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('costumers.destroy', $costumer) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-customer"
                                            data-customer-id="{{ $costumer->id }}">
                                            <i class="fas fa-trash-alt mr-1"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No customers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $costumers->links() }}
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
                                Delete Customer
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this customer? This action cannot be undone.
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
                let customerIdToDelete = null;

                // Funcție pentru a afișa modalul
                function showModal() {
                    deleteModal.classList.remove('hidden');
                }

                // Funcție pentru a ascunde modalul
                function hideModal() {
                    deleteModal.classList.add('hidden');
                }

                // Event listener pentru butoanele de ștergere
                document.querySelectorAll('.delete-customer').forEach(button => {
                    button.addEventListener('click', function() {
                        customerIdToDelete = this.getAttribute('data-customer-id');
                        showModal();
                    });
                });

                // Event listener pentru butonul de anulare
                cancelDeleteBtn.addEventListener('click', hideModal);

                // Event listener pentru butonul de confirmare
                confirmDeleteBtn.addEventListener('click', function() {
                    if (customerIdToDelete) {
                        // Creăm și trimitem formularul de ștergere
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/costumers/${customerIdToDelete}`;
                        form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@endsection
