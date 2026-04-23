{{--
    FILE: resources/views/layouts/navigation.blade.php
    PURPOSE: Professional responsive navigation bar with authentication handling
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27

    FEATURES:
    - Responsive design with mobile hamburger menu
    - Authentication-aware (shows different content for guests/users)
    - Shopping cart indicator with item count
    - Dropdown menu with smooth animations
    - Active route highlighting
    - Professional color scheme (Slate/Indigo)
    - Accessibility features (ARIA labels, keyboard navigation)
--}}

<nav x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }"
     class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">

    {{-- Main Navigation Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Left Side: Logo & Desktop Navigation --}}
            <div class="flex">

                {{-- Logo Section --}}
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        {{-- Application Logo/Icon --}}
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="hidden md:block text-xl font-bold bg-gradient-to-r from-indigo-600 to-indigo-800 bg-clip-text text-transparent">
                            E-Commerce
                        </span>
                    </a>
                </div>

                {{-- Desktop Navigation Links --}}
                <div class="hidden sm:ml-8 sm:flex sm:space-x-6">
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} inline-flex items-center px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('home') ? 'border-indigo-600' : 'border-transparent' }}">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="{{ request()->routeIs('products.*') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} inline-flex items-center px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('products.*') ? 'border-indigo-600' : 'border-transparent' }}">
                        Products
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} inline-flex items-center px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('dashboard') ? 'border-indigo-600' : 'border-transparent' }}">
                            Dashboard
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Right Side: Cart, User Menu & Mobile Toggle --}}
            <div class="flex items-center gap-3">

                {{-- Shopping Cart (Authenticated Users) --}}
                @auth
                    <a href="{{ route('cart.index') }}"
                       class="relative p-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>

                        {{-- Cart Badge --}}
                        @php
                            $cartCount = \App\Http\Controllers\CartController::getCartCount();
                        @endphp
                        @if ($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif

                        <span class="sr-only">Shopping cart</span>
                    </a>
                @endauth

                {{-- User Profile Dropdown (Authenticated) --}}
                @auth
                    <div class="relative ml-3" x-data="{ open: false }">

                        {{-- Dropdown Trigger --}}
                        <button @click="open = ! open"
                                @click.outside="open = false"
                                type="button"
                                class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            {{-- User Avatar --}}
                            <img class="w-8 h-8 rounded-lg object-cover border border-slate-200"
                                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff' }}"
                                 alt="{{ auth()->user()->name }}">

                            {{-- User Name --}}
                            <span class="hidden md:block text-slate-700">
                                {{ auth()->user()->name }}
                            </span>

                            {{-- Dropdown Arrow --}}
                            <svg class="w-4 h-4 text-slate-400 transition-transform"
                                 :class="{ 'rotate-180': open }"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50"
                             style="display: none;">

                            {{-- User Info Header --}}
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Menu Items --}}
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Settings
                            </a>

                            <a href="{{ route('dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Dashboard
                            </a>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                {{-- Guest Authentication Links --}}
                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-md hover:shadow-lg">
                            Sign Up
                        </a>
                    </div>
                @endguest

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = ! mobileMenuOpen"
                        type="button"
                        class="sm:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        aria-controls="mobile-menu"
                        :aria-expanded="mobileMenuOpen">
                    <span class="sr-only">Open main menu</span>

                    {{-- Hamburger Icon --}}
                    <svg x-show="! mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    {{-- Close Icon --}}
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        id="mobile-menu"
        class="sm:hidden bg-white border-t border-slate-200 shadow-lg"
        style="display: none;">

        <div class="px-4 py-4 space-y-3">
            <a href="{{ route('home') }}"
            class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                Home
            </a>
            <a href="{{ route('products.index') }}"
            class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                Products
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }} transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('cart.index') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    Shopping Cart
                    @if ($cartCount > 0)
                        <span class="ml-2 px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Mobile User Section --}}
                <div class="pt-4 mt-4 border-t border-slate-200">
                    <div class="flex items-center gap-3 px-4 py-3">
                        <img class="w-10 h-10 rounded-xl object-cover border border-slate-200"
                            src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff' }}"
                            alt="{{ auth()->user()->name }}">
                        <div>
                            <p class="font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-3 rounded-xl text-base font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            Profile Settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-3 rounded-xl text-base font-medium text-red-600 hover:bg-red-50 transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="pt-4 mt-4 border-t border-slate-200 space-y-2">
                    <a href="{{ route('login') }}"
                    class="block w-full px-4 py-3 text-center rounded-xl text-base font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                    class="block w-full px-4 py-3 text-center rounded-xl text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                        Create Account
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>
