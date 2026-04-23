{{--
    FILE: resources/views/profile/edit.blade.php
    PURPOSE: Main profile management page with tabbed interface
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27

    FEATURES:
    - Tabbed navigation for different profile sections
    - User avatar display with status indicator
    - Breadcrumb navigation
    - Success/error message handling
    - Responsive sidebar layout
--}}

@extends('layouts.app')

@section('title', 'Profile Settings | Professional Store')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header with User Info --}}
            <div class="mb-8">
                {{-- Breadcrumb Navigation --}}
                <nav class="flex mb-4 text-sm" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 rtl:space-x-reverse">
                        <li>
                            <a href="{{ route('home') }}" class="text-slate-600 hover:text-indigo-600 transition-colors">
                                Home
                            </a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li>
                        <li>
                            <span class="text-slate-900 font-semibold" aria-current="page">Profile Settings</span>
                        </li>
                    </ol>
                </nav>

                {{-- User Profile Header --}}
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img
                            src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&size=128' }}"
                            alt="{{ auth()->user()->name }}"
                            class="w-20 h-20 rounded-2xl border-4 border-white shadow-lg object-cover"
                        >
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full" title="Online"></div>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-slate-900">{{ auth()->user()->name }}</h1>
                        <p class="text-slate-600">{{ auth()->user()->email }}</p>
                        <p class="text-sm text-slate-500 mt-1">
                            Member since {{ auth()->user()->created_at->format('F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Success Messages --}}
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- Sidebar Navigation --}}
                <aside class="lg:col-span-1">
                    <nav class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 space-y-2 sticky top-8">
                        <button
                            type="button"
                            onclick="switchTab('profile')"
                            id="tab-button-profile"
                            class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 bg-indigo-50 text-indigo-700 shadow-sm"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile Information
                        </button>

                        <button
                            type="button"
                            onclick="switchTab('password')"
                            id="tab-button-password"
                            class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 text-slate-600 hover:bg-slate-50"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Security
                        </button>

                        <button
                            type="button"
                            onclick="switchTab('delete')"
                            id="tab-button-delete"
                            class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 text-red-600 hover:bg-red-50"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Account
                        </button>
                    </nav>
                </aside>

                {{-- Main Content Area --}}
                <main class="lg:col-span-3">

                    {{-- Profile Information Tab --}}
                    <div id="tab-profile" class="tab-content bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Password Security Tab --}}
                    <div id="tab-password" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Delete Account Tab --}}
                    <div id="tab-delete" class="tab-content hidden bg-white rounded-2xl shadow-sm border border-red-200 p-6 md:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>

                </main>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        /**
         * Tab Switching Functionality
         * Handles smooth transitions between profile sections
         */
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('bg-indigo-50', 'text-indigo-700', 'shadow-sm');
                button.classList.add('text-slate-600', 'hover:bg-slate-50');
            });

            // Show selected tab content
            const selectedContent = document.getElementById(`tab-${tabName}`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
                // Add fade-in animation
                selectedContent.style.animation = 'fadeIn 0.3s ease-in-out';
            }

            // Activate selected button
            const selectedButton = document.getElementById(`tab-button-${tabName}`);
            if (selectedButton) {
                selectedButton.classList.remove('text-slate-600', 'hover:bg-slate-50');
                selectedButton.classList.add('bg-indigo-50', 'text-indigo-700', 'shadow-sm');
            }

            // Update URL hash without scrolling
            history.pushState(null, null, `#${tabName}`);
        }

        // Initialize tab based on URL hash or default to 'profile'
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.replace('#', '');
            const validTabs = ['profile', 'password', 'delete'];

            if (validTabs.includes(hash)) {
                switchTab(hash);
            } else {
                switchTab('profile');
            }
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
