{{--
    FILE: resources/views/profile/partials/update-profile-information-form.blade.php
    PURPOSE: Update user profile information with avatar upload
    FEATURES:
    - Real-time image preview
    - Form validation with error display
    - Email verification status
    - Responsive layout
--}}

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('patch')

    {{-- Avatar Upload Section --}}
    <div class="flex items-center gap-6">
        <div class="relative group">
            <img
                id="avatar-preview"
                src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&size=128' }}"
                alt="{{ auth()->user()->name }}"
                class="w-24 h-24 rounded-2xl border-2 border-slate-200 object-cover transition-opacity group-hover:opacity-75"
            >
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-2xl transition-all flex items-center justify-center cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <div class="flex-1">
            <input
                type="file"
                id="avatar-input"
                name="avatar"
                accept="image/*"
                class="hidden"
                onchange="previewAvatar(this)"
            >
            <button
                type="button"
                onclick="document.getElementById('avatar-input').click()"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors"
            >
                Change Photo
            </button>
            @if (auth()->user()->avatar)
                <button
                    type="button"
                    onclick="removeAvatar()"
                    class="ml-3 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors"
                >
                    Remove
                </button>
            @endif
            <p class="mt-2 text-xs text-slate-500">JPG, GIF or PNG. Max size 2MB.</p>
        </div>
    </div>

    <hr class="border-slate-200">

    {{-- Name Field --}}
    <div>
        <label for="name" class="block text-sm font-medium text-slate-700">Full Name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', auth()->user()->name) }}"
            required
            autocomplete="name"
            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror"
            placeholder="Enter your full name"
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email Field --}}
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email', auth()->user()->email) }}"
            required
            autocomplete="email"
            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror"
            placeholder="your.email@example.com"
        >
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        {{-- Email Verification Status --}}
        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
            <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                <p class="text-sm text-amber-800">
                    Your email address is unverified.
                    <button type="button" onclick="event.target.closest('form').querySelector('[name=verification_send]').click();" class="underline hover:no-underline font-medium">
                        Click here to re-send the verification email.
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-emerald-600">A new verification link has been sent to your email address.</p>
                @endif
            </div>
        @endif
    </div>

    {{-- Phone Field --}}
    <div>
        <label for="phone" class="block text-sm font-medium text-slate-700">
            Phone Number
            <span class="text-slate-400">(Optional)</span>
        </label>
        <input
            type="tel"
            name="phone"
            id="phone"
            value="{{ old('phone', auth()->user()->phone ?? '') }}"
            autocomplete="tel"
            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('phone') border-red-300 @enderror"
            placeholder="+1 (555) 123-4567"
        >
        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Submit Button --}}
    <div class="flex items-center gap-4">
        <button
            type="submit"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-emerald-600 animate-fade-in">Saved successfully!</p>
        @endif
    </div>
</form>

<script>
    /**
     * Avatar Preview Functionality
     * Shows preview of selected image before upload
     */
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    /**
     * Remove Avatar
     * Clears the avatar input and resets preview
     */
    function removeAvatar() {
        if (confirm('Are you sure you want to remove your avatar?')) {
            document.getElementById('avatar-input').value = '';
            document.getElementById('avatar-preview').src = 'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff&size=128';

            // Create hidden input to signal avatar removal
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_avatar';
            hiddenInput.value = '1';
            document.querySelector('form').appendChild(hiddenInput);
        }
    }
</script>
