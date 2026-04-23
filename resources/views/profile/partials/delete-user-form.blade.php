{{--
    FILE: resources/views/profile/partials/delete-user-form.blade.php
    PURPOSE: Secure account deletion with password confirmation
    FEATURES:
    - Destructive action warning
    - Modal confirmation dialog
    - Password verification required
    - Permanent deletion notice
--}}

<div class="space-y-6">
    {{-- Warning Banner --}}
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-800">Warning: This action cannot be undone</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>Once your account is deleted, all of your data, orders, and settings will be permanently removed. This includes:</p>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>Your profile information</li>
                        <li>Your order history</li>
                        <li>Your saved items and wishlists</li>
                        <li>All associated data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Button --}}
    <button
        type="button"
        onclick="openDeleteModal()"
        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition-colors"
    >
        Delete Account
    </button>

    {{-- Confirmation Modal --}}
    <div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div
            class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
            onclick="closeDeleteModal()"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            {{-- Modal Panel --}}
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                {{-- Modal Header --}}
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-semibold text-slate-900" id="modal-title">
                                Delete Your Account?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-600">
                                    Please enter your password to confirm you would like to permanently delete your account. This action cannot be undone.
                                </p>
                            </div>

                            {{-- Password Input --}}
                            <div class="mt-4">
                                <form action="{{ route('profile.destroy') }}" method="POST" id="delete-account-form">
                                    @csrf
                                    @method('delete')

                                    <input
                                        type="password"
                                        name="password"
                                        id="delete-password"
                                        required
                                        placeholder="Enter your password"
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('password') border-red-300 @enderror"
                                    >
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button
                        type="button"
                        onclick="confirmDelete()"
                        class="inline-flex w-full justify-center rounded-xl border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Delete Account
                    </button>
                    <button
                        type="button"
                        onclick="closeDeleteModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-base font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Open Delete Modal
     * Shows the confirmation modal and focuses password input
     */
    function openDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling

        setTimeout(() => {
            document.getElementById('delete-password').focus();
        }, 100);
    }

    /**
     * Close Delete Modal
     * Hides the modal and clears the form
     */
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('delete-password').value = '';

        // Clear any error messages
        const errorElement = document.querySelector('#delete-password + .text-red-600');
        if (errorElement) {
            errorElement.remove();
        }
    }

    /**
     * Confirm Delete
     * Submits the delete form
     */
    function confirmDelete() {
        const form = document.getElementById('delete-account-form');
        const password = document.getElementById('delete-password').value;

        if (password.length < 1) {
            alert('Please enter your password to confirm deletion.');
            return;
        }

        if (confirm('Are you absolutely sure? This action cannot be undone.')) {
            form.submit();
        }
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('delete-modal').classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>
