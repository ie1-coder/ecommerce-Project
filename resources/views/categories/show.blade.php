{{--
    FILE: resources/views/products/show.blade.php
    PURPOSE: Professional product detail page with enhanced UX/UI
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: {{ date('Y-m-d') }}

    DESIGN PRINCIPLES:
    - Minimalist aesthetic with purposeful whitespace
    - Clear visual hierarchy guiding user to conversion
    - Accessible markup with semantic HTML5 elements
    - Performance-optimized image loading strategies
    - Mobile-first responsive breakpoints

    FIX APPLIED:
    - Replaced undefined route('category.show') with safe fallback to route('products.index')
    - Added null-safe checks for category relationship
--}}

@extends('layouts.app')

@section('title', $category->name . ' | Professional Store')

@section('meta_description', $category->description ?? 'Explore our ' . $category->name . ' category for premium quality products with fast shipping and secure checkout.')

@section('content')
    {{--
        MAIN CONTAINER
        - Full viewport height minimum with subtle background gradient
        - Padding optimized for mobile and desktop viewing
        - Max-width constraint for readability on large screens
    --}}
    <main class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-8 md:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{--
                BREADCRUMB NAVIGATION
                - Semantic nav element with structured data potential
                - Hover states with smooth color transitions
                - Mobile-optimized text sizing
                - FIX: Uses products.index as fallback when category route is undefined
            --}}
            <nav class="flex items-center mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 rtl:space-x-reverse">
                    <li>
                        <a href="{{ route('home') }}"
                        class="text-slate-600 hover:text-indigo-600 transition-colors duration-200 font-medium">
                            Home
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        {{-- FIX: Safe category link with fallback to products.index --}}
                        @if ($category->category)
                            {{-- If you have category routes, uncomment the line below --}}
                            {{-- <a href="{{ route('categories.show', $product->category) }}" class="text-slate-600 hover:text-indigo-600 transition-colors duration-200 font-medium"> --}}
                            <a href="{{ route('products.index', ['category' => $product->category->id]) }}"
                            class="text-slate-600 hover:text-indigo-600 transition-colors duration-200 font-medium">
                                {{ $product->category->name }}
                            </a>
                        @else
                            <a href="{{ route('products.index') }}"
                            class="text-slate-600 hover:text-indigo-600 transition-colors duration-200 font-medium">
                                Products
                            </a>
                        @endif
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <span class="text-slate-900 font-semibold" aria-current="page">
                            {{ Str::limit($category->name, 40) }}
                        </span>
                    </li>
                </ol>
            </nav>

            {{--
                PRODUCT GRID LAYOUT
                - Two-column layout on large screens, stacked on mobile
                - Generous gap spacing for visual breathing room
                - Flex direction optimized for content priority
            --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 xl:gap-16">

                {{--
                    PRODUCT MEDIA SECTION
                    - Sticky positioning on desktop for enhanced browsing
                    - Image optimization with lazy loading and aspect ratio
                    - Placeholder fallback with dynamic text encoding
                --}}
                <section class="lg:sticky lg:top-8 space-y-6" aria-label="Product images">
                    {{-- Primary Product Image --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group">
                        <div class="aspect-square relative overflow-hidden">
                            <img
                                src="{{ $category->image ?? 'https://via.placeholder.com/800x800?text=' . urlencode($category->name) }}"
                                alt="{{ $category->name }} - High resolution product image"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="eager"
                                width="800"
                                height="800"
                            >

                            {{-- Stock Status Badge --}}
                            @if ($category->stock <= 5 && $category->stock > 0)
                                <span class="absolute top-4 left-4 px-3 py-1.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full border border-amber-200">
                                    Low stock
                                </span>
                            @endif
                        </div>
                    </div>

                    {{--
                        IMAGE THUMBNAILS (Prepared for future multi-image support)
                        - Hidden by default, activate when product->images collection exists
                        - Horizontal scroll on mobile, grid on desktop
                    --}}
                    @if ($category->images?->isNotEmpty())
                        <div class="grid grid-cols-4 gap-3">
                            @foreach ($product->images as $image)
                                <button
                                    type="button"
                                    class="aspect-square rounded-xl overflow-hidden border-2 border-transparent hover:border-indigo-500 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    aria-label="View {{ $product->name }} - Image {{ $loop->iteration }}"
                                >
                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $category->name }} thumbnail {{ $loop->iteration }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                </button>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{--
                    PRODUCT INFORMATION SECTION
                    - Flex column layout for logical content flow
                    - Sticky add-to-cart bar on mobile (optional enhancement)
                    - Clear typography hierarchy with semantic headings
                --}}
                <section class="flex flex-col" aria-label="Product details">

                    {{-- Product Header: Title, Category, Availability --}}
                    <header class="mb-6">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-900 mb-4 leading-tight">
                            {{ $category->name }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            {{-- Category Badge --}}
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $category->category->name ?? 'Uncategorized' }}
                            </span>

                            {{-- Stock Status Indicator --}}
                            @if ($category->stock > 0)
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    In Stock ({{ $category->stock }})
                                </span>
                            @else
                                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </header>

                    {{-- Pricing Section with Visual Emphasis --}}
                    <div class="mb-8 pb-8 border-b border-slate-200">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl md:text-5xl font-extrabold text-slate-900">
                                {{ number_format($category->price, 2) }}
                            </span>
                            <span class="text-xl text-slate-500 font-medium">USD</span>
                        </div>
                        @if ($category->original_price && $category->original_price > $category->price)
                            <p class="mt-2 text-slate-500 line-through">
                                {{ number_format($category->original_price, 2) }} USD
                            </p>
                            <p class="text-emerald-600 font-semibold text-sm">
                                Save {{ number_format((($category->original_price - $category->price) / $category->original_price) * 100, 0) }}%
                            </p>
                        @endif
                    </div>

                    {{-- Product Description --}}
                    <article class="prose prose-slate prose-lg max-w-none mb-10">
                        <h2 class="text-xl font-semibold text-slate-900 mb-3">Overview</h2>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $category->description }}
                        </p>
                    </article>

                    {{--
                        PRODUCT SPECIFICATIONS (Collapsible on mobile)
                        - Structured data for technical details
                        - Easy to scan key-value pairs
                    --}}
                    @if ($category->specifications)
                        <details class="mb-8 group">
                            <summary class="flex items-center justify-between cursor-pointer list-none">
                                <span class="text-lg font-semibold text-slate-900">Specifications</span>
                                <svg class="w-5 h-5 text-slate-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6">
                                    @foreach ($category->specifications as $key => $value)
                                        <div>
                                            <dt class="text-sm font-medium text-slate-500">{{ ucfirst($key) }}</dt>
                                            <dd class="text-sm text-slate-900">{{ $value }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        </details>
                    @endif

                    {{--
                        ADD TO CART FORM
                        - CSRF protection and route binding
                        - Quantity selector with increment/decrement controls
                        - Disabled state handling for out-of-stock items
                        - Session feedback messages with auto-dismiss (JS enhancement)
                    --}}
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto space-y-6" novalidate>
                        @csrf

                        {{-- Quantity Selector --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <label for="quantity" class="text-base font-semibold text-slate-700">
                                Quantity
                            </label>
                            <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-shadow">
                                <button
                                    type="button"
                                    class="quantity-decrease px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    aria-label="Decrease quantity"
                                    {{ $product->stock <= 1 ? 'disabled' : '' }}
                                >
                                    −
                                </button>
                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="w-16 text-center border-x border-slate-300 py-3 focus:outline-none focus:ring-0 text-slate-900 font-medium"
                                    aria-live="polite"
                                >
                                <button
                                    type="button"
                                    class="quantity-increase px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    aria-label="Increase quantity"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        {{-- Primary Action Button --}}
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-10 py-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-lg rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            {{ $product->stock == 0 ? 'disabled' : '' }}
                            aria-busy="false"
                        >
                            {{ $product->stock > 0 ? 'Add to Cart' : 'Notify When Available' }}
                        </button>

                        {{-- Secondary Actions --}}
                        <div class="flex items-center gap-4 pt-2">
                            <button
                                type="button"
                                class="text-sm text-slate-600 hover:text-indigo-600 font-medium transition-colors flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Add to Wishlist
                            </button>
                            <button
                                type="button"
                                class="text-sm text-slate-600 hover:text-indigo-600 font-medium transition-colors flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Share
                            </button>
                        </div>

                        {{-- Session Feedback Messages --}}
                        @if (session('success'))
                            <div
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 5000)"
                                class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium"
                                role="alert"
                            >
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 7000)"
                                class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium"
                                role="alert"
                            >
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>

                    {{-- Trust Badges / Policy Highlights --}}
                    <div class="mt-10 pt-8 border-t border-slate-200 grid grid-cols-2 sm:grid-cols-3 gap-4 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-xs text-slate-600 font-medium">Free Shipping</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-xs text-slate-600 font-medium">Secure Checkout</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span class="text-xs text-slate-600 font-medium">30-Day Returns</span>
                        </div>
                    </div>

                </section>
            </div>

            {{--
                RELATED PRODUCTS SECTION
                - Conditional rendering based on collection availability
                - Grid layout with responsive column counts
                - Consistent card design with hover interactions
                - FIX: Safe "View All" link with fallback
            --}}
            @if ($relatedProducts->isNotEmpty())
                <section class="mt-20 pt-12 border-t border-slate-200" aria-label="Related products">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">You May Also Like</h2>
                        {{-- FIX: Safe "View All" link --}}
                        <a href="{{ $product->category ? route('products.index', ['category' => $product->category->id]) : route('products.index') }}"
                            class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm transition-colors">
                            View All →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $related)
                            {{-- FIX: Changed route name from 'product.show' to 'products.show' --}}
                            <a href="{{ route('products.show', $related) }}"
                            class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 overflow-hidden transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                {{-- Product Image Container --}}
                                <div class="aspect-square overflow-hidden bg-slate-50">
                                    <img
                                        src="{{ $related->image ?? 'https://via.placeholder.com/400?text=' . urlencode($related->name) }}"
                                        alt="{{ $related->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                        width="400"
                                        height="400"
                                    >
                                </div>

                                {{-- Product Info Card --}}
                                <div class="p-5">
                                    <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                        {{ $related->name }}
                                    </h3>
                                    <p class="text-sm text-slate-500 mt-1 line-clamp-2">
                                        {{ Str::limit($related->description, 80) }}
                                    </p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-lg font-bold text-slate-900">
                                            {{ number_format($related->price, 2) }} USD
                                        </span>
                                        @if ($related->stock > 0)
                                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                                In Stock
                                            </span>
                                        @else
                                            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                                Out
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>
    </main>
@endsection

@section('scripts')
    {{--
        CLIENT-SIDE INTERACTIONS
        - Quantity selector logic with boundary validation
        - Smooth scroll behavior for anchor links
        - Image gallery interactions (prepared for lightbox integration)

        NOTE: Consider migrating to Alpine.js or Vue for complex state management
    --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Quantity Selector Controls
            const quantityInput = document.getElementById('quantity');
            const decreaseButton = document.querySelector('.quantity-decrease');
            const increaseButton = document.querySelector('.quantity-increase');
            const maxStock = {{ (int) $product->stock }};

            /**
             * Update button disabled states based on current quantity value
             * @param {number} currentQuantity - The current value in the quantity input
             */
            const updateButtonStates = (currentQuantity) => {
                if (decreaseButton) {
                    decreaseButton.disabled = currentQuantity <= 1;
                }
                if (increaseButton) {
                    increaseButton.disabled = currentQuantity >= maxStock;
                }
            };

            // Initialize button states on page load
            if (quantityInput) {
                updateButtonStates(parseInt(quantityInput.value));

                // Decrease quantity handler
                decreaseButton?.addEventListener('click', () => {
                    const current = parseInt(quantityInput.value) || 1;
                    if (current > 1) {
                        quantityInput.value = current - 1;
                        updateButtonStates(current - 1);
                    }
                });

                // Increase quantity handler
                increaseButton?.addEventListener('click', () => {
                    const current = parseInt(quantityInput.value) || 1;
                    if (current < maxStock) {
                        quantityInput.value = current + 1;
                        updateButtonStates(current + 1);
                    }
                });

                // Handle direct input changes
                quantityInput.addEventListener('change', () => {
                    let value = parseInt(quantityInput.value);
                    if (isNaN(value) || value < 1) value = 1;
                    if (value > maxStock) value = maxStock;
                    quantityInput.value = value;
                    updateButtonStates(value);
                });
            }

            // Optional: Add smooth scroll for anchor links within the page
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        });
    </script>
@endsection
