{{--
    FILE: resources/views/profile/partials/update-password-form.blade.php
    PURPOSE: Secure password update with strength validation
    FEATURES:
    - Real-time password strength indicator
    - Password requirements checklist
    - Confirmation matching validation
    - Current password verification
--}}

<form action="{{ route('password.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('put')

    {{-- Current Password --}}
    <div>
        <label for="current_password" class="block text-sm font-medium text-slate-700">Current Password</label>
        <input
            type="password"
            name="current_password"
            id="current_password"
            required
            autocomplete="current-password"
            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('current_password') border-red-300 @enderror"
            placeholder="Enter current password"
        >
        @error('current_password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- New Password --}}
    <div>
        <label for="password" class="block text-sm font-medium text-slate-700">New Password</label>
        <input
            type="password"
            name="password"
            id="password"
            required
            autocomplete="new-password"
            oninput="calculatePasswordStrength(this.value)"
            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-300 @enderror"
            placeholder="Enter new password"
        >

        {{-- Password Strength Indicator --}}
        <div id="password-strength-container" class="mt-2 hidden">
            <div class="flex gap-1 h-1.5">
                <div class="strength-bar flex-1 rounded-full bg-slate-200 transition-colors"></div>
                <div class="strength-bar flex-1 rounded-full bg-slate-200 transition-colors"></div>
                <div class="strength-bar flex-1 rounded-full bg-slate-200 transition-colors"></div>
                <div class="strength-bar flex-1 rounded-full bg-slate-200 transition-colors"></div>
                <div class="strength-bar flex-1 rounded-full bg-slate-200 transition-colors"></div>
            </div>
            <p id="password-strength-label" class="mt-1 text-xs text-slate-500"></p>
        </div>

        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm New Password</label>
        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            required
            autocomplete="new-password"
            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password_confirmation') border-red-300 @enderror"
            placeholder="Confirm new password"
        >
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Password Requirements --}}
    <div class="bg-slate-50 rounded-xl p-4">
        <p class="text-sm font-medium text-slate-700 mb-2">Password must contain:</p>
        <ul class="text-sm text-slate-600 space-y-1">
            <li id="req-length" class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                At least 8 characters
            </li>
            <li id="req-uppercase" class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                One uppercase letter
            </li>
            <li id="req-lowercase" class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                One lowercase letter
            </li>
            <li id="req-number" class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                One number
            </li>
        </ul>
    </div>

    {{-- Submit Button --}}
    <div class="flex items-center gap-4">
        <button
            type="submit"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Update Password
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-sm text-emerald-600 animate-fade-in">Password updated successfully!</p>
        @endif
    </div>
</form>

<script>
    /**
     * Password Strength Calculation
     * Evaluates password strength based on multiple criteria
     */
    function calculatePasswordStrength(password) {
        const container = document.getElementById('password-strength-container');
        const label = document.getElementById('password-strength-label');
        const bars = document.querySelectorAll('.strength-bar');

        // Show container when user starts typing
        if (password.length > 0) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            return;
        }

        let strength = 0;

        // Check length
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;

        // Check character types
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        // Update strength bars
        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-emerald-500'];
        const labels = ['Very Weak', 'Weak', 'Fair', 'Strong', 'Very Strong'];

        bars.forEach((bar, index) => {
            if (index < strength) {
                bar.className = `strength-bar flex-1 rounded-full transition-colors ${colors[Math.min(strength - 1, 4)]}`;
            } else {
                bar.className = 'strength-bar flex-1 rounded-full bg-slate-200 transition-colors';
            }
        });

        if (strength > 0) {
            label.textContent = labels[Math.min(strength - 1, 4)];
            label.className = `mt-1 text-xs ${strength >= 4 ? 'text-emerald-600' : 'text-slate-500'}`;
        }

        // Update requirements checklist
        updateRequirement('req-length', password.length >= 8);
        updateRequirement('req-uppercase', /[A-Z]/.test(password));
        updateRequirement('req-lowercase', /[a-z]/.test(password));
        updateRequirement('req-number', /\d/.test(password));
    }

    /**
     * Update Requirement Checkmark
     * Shows/hides checkmark for password requirements
     */
    function updateRequirement(id, met) {
        const element = document.getElementById(id);
        const svg = element.querySelector('svg');

        if (met) {
            element.classList.add('text-emerald-600');
            element.classList.remove('text-slate-600');
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
        } else {
            element.classList.remove('text-emerald-600');
            element.classList.add('text-slate-600');
            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
        }
    }
</script>
