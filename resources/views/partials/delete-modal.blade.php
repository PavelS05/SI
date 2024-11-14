{{-- resources/views/partials/delete-modal.blade.php --}}
<div id="deleteModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            x-transition:enter="ease-out duration-100" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Modal panel -->
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Warning Icon with animated pulse -->
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10
                              animate-pulse">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900" id="modal-title">
                            Confirm Deletion
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="modal-description"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" id="confirmDelete"
                    class="w-full inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm
                           transition-all duration-150 ease-in-out hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
                <button type="button" id="cancelDelete"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm
                           transition-all duration-150 ease-in-out">
                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function initializeDeleteModal({
            itemType = 'item',
            deleteUrl = '',
        }) {
            const deleteModal = document.getElementById('deleteModal');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const modalTitle = document.getElementById('modal-title');
            const modalDescription = document.getElementById('modal-description');
            let itemIdToDelete = null;

            function showModal(itemId, itemName = '') {
                itemIdToDelete = itemId;

                // Animație pentru deschidere
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('fade-in');

                // Setăm title și description cu animație de fade
                setTimeout(() => {
                    modalTitle.textContent = `Delete ${itemType}`;
                    modalDescription.textContent = itemName ?
                        `Are you sure you want to delete "${itemName}"? This action cannot be undone.` :
                        `Are you sure you want to delete this ${itemType.toLowerCase()}? This action cannot be undone.`;
                }, 150);
            }

            function hideModal() {
                // Animație pentru închidere
                deleteModal.classList.add('fade-out');
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('fade-in', 'fade-out');
                    itemIdToDelete = null;
                }, 150);
            }

            // Event Listeners
            document.querySelectorAll('.delete-' + itemType.toLowerCase()).forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-' + itemType.toLowerCase() + '-id');
                    const itemName = this.getAttribute('data-name') || '';
                    showModal(itemId, itemName);
                });
            });

            confirmDeleteBtn.addEventListener('click', function() {
                if (itemIdToDelete) {
                    // Adăugăm animație la buton în timpul procesării
                    confirmDeleteBtn.classList.add('opacity-75', 'cursor-wait');

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl + itemIdToDelete;
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });

            cancelDeleteBtn.addEventListener('click', hideModal);

            // Close on click outside
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    hideModal();
                }
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    hideModal();
                }
            });
        }

        // Adăugăm stiluri pentru animații
        const style = document.createElement('style');
        style.textContent = `
    .fade-in {
        animation: fadeIn 0.15s ease-in forwards;
    }
    .fade-out {
        animation: fadeOut 0.15s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.95); }
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
