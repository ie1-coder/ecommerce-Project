{{--
    FILE: resources/views/products/index.blade.php
    PURPOSE: Display paginated, filterable product catalog with enhanced UX
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27
    FEATURES: Responsive filters, sorting, view toggle, structured data, accessibility
--}}

@extends('layouts.app')

@section('title', 'All Products | Professional Store')
@section('meta_description', 'Browse our curated collection of premium products with competitive prices, fast shipping, and secure checkout.')

{{-- Structured Data for SEO --}}
@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "All Products",
    "description": "@yield('meta_description')",
    "url": "{{ url()->current() }}",
    "itemListElement": [
        @foreach($products as $index => $product)
        {
            "@type": "Product",
            "position": {{ $index + 1 }},
            "name": "{{ addslashes($product->name) }}",
            "image": "{{ $product->image ?? 'https://via.placeholder.com/400' }}",
            "description": "{{ addslashes(Str::limit($product->description, 120)) }}",
            "offers": {
                "@type": "Offer",
                "priceCurrency": "USD",
                "price": "{{ $product->price }}",
                "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush

@section('content')
    {{-- Page Header with Enhanced Breadcrumb --}}
    <header class="bg-gradient-to-b from-slate-50 to-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Breadcrumb Navigation --}}
            <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('home') }}"
                        itemprop="item"
                        class="text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                    <li class="text-slate-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span class="text-slate-900 font-semibold" itemprop="name" aria-current="page">Products</span>
                        <meta itemprop="position" content="2">
                    </li>
                </ol>
            </nav>

            {{-- Header Content --}}
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight">
                        All Products
                    </h1>
                    <p class="mt-2 text-slate-600 max-w-2xl">
                        Discover our curated collection of premium products, crafted for quality and designed for performance.
                    </p>
                </div>
                {{-- Active Filters Summary --}}
                @if(request()->hasAny(['category', 'min_price', 'max_price']))
                    <div class="flex flex-wrap gap-2">
                        @if(request('category'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-50 text-indigo-700 text-sm font-medium rounded-full">
                                {{ $categories->firstWhere('id', request('category'))->name ?? 'Category' }}
                                <a href="{{ route('products.index', request()->except('category')) }}"
                                   class="hover:text-indigo-900"
                                   aria-label="Remove category filter"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                        @if(request('min_price') || request('max_price'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-50 text-indigo-700 text-sm font-medium rounded-full">
                                ${{ request('min_price', 0) }} - ${{ request('max_price', '∞') }}
                                <a href="{{ route('products.index', request()->except(['min_price', 'max_price'])) }}"
                                   class="hover:text-indigo-900"
                                   aria-label="Remove price filter"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Mobile Filter Toggle --}}
            <button type="button"
                    id="mobile-filters-toggle"
                    class="lg:hidden flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors"
                    aria-expanded="false"
                    aria-controls="mobile-filters"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
                @if(request()->hasAny(['category', 'min_price', 'max_price']))
                    <span class="w-2 h-2 bg-indigo-600 rounded-full"></span>
                @endif
            </button>

            {{-- Sidebar Filters --}}
            <aside id="mobile-filters"
                   class="lg:w-72 flex-shrink-0 hidden lg:block"
            >
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:sticky lg:top-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Filters</h2>
                        <button type="button"
                                id="close-mobile-filters"
                                class="lg:hidden p-1 text-slate-400 hover:text-slate-600"
                                aria-label="Close filters"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('products.index') }}" method="GET" class="space-y-6" id="filter-form">
                        {{-- Preserve existing params except filterable ones --}}
                        @foreach(request()->except(['category', 'min_price', 'max_price', 'sort', 'page']) as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        {{-- Category Filter --}}
                        <div class="space-y-3">
                            <label for="category" class="block text-sm font-medium text-slate-700">
                                Category
                            </label>
                            <select name="category" id="category"
                                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-shadow"
                                    onchange="document.getElementById('filter-form').submit()"
                            >
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }} ({{ $category->products_count ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price Range Filter --}}
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-slate-700">
                                Price Range
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="min_price" class="sr-only">Minimum Price</label>
                                    <input type="number" name="min_price" id="min_price"
                                           placeholder="Min"
                                           value="{{ request('min_price') }}"
                                           min="0"
                                           class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-shadow"
                                    >
                                </div>
                                <div>
                                    <label for="max_price" class="sr-only">Maximum Price</label>
                                    <input type="number" name="max_price" id="max_price"
                                           placeholder="Max"
                                           value="{{ request('max_price') }}"
                                           min="0"
                                           class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-shadow"
                                    >
                                </div>
                            </div>
                        </div>

                        {{-- Availability Filter --}}
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-slate-700">
                                Availability
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="in_stock" value="1"
                                           {{ request('in_stock') ? 'checked' : '' }}
                                           class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer"
                                           onchange="document.getElementById('filter-form').submit()"
                                    >
                                    <span class="text-sm text-slate-700 group-hover:text-slate-900 transition-colors">
                                        In Stock Only
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- Filter Actions --}}
                        <div class="flex gap-3 pt-4 border-t border-slate-100">
                            <button type="submit"
                                    class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Apply
                            </button>
                            <a href="{{ route('products.index', request()->except(['category', 'min_price', 'max_price', 'in_stock', 'page'])) }}"
                               class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors text-center focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2"
                            >
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Products Grid Section --}}
            <section class="flex-1">
                {{-- Toolbar: Results Count, Sort, View Toggle --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-slate-200">
                    <p class="text-slate-600" aria-live="polite">
                        Showing
                        <span class="font-semibold text-slate-900">{{ $products->firstItem() ?? 0 }}</span>
                        –
                        <span class="font-semibold text-slate-900">{{ $products->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-slate-900">{{ $products->total() }}</span>
                        results
                    </p>

                    <div class="flex items-center gap-3">
                        {{-- Sort Dropdown --}}
                        <div class="relative">
                            <label for="sort" class="sr-only">Sort Products</label>
                            <select id="sort" name="sort"
                                    onchange="window.location.href=this.value"
                                    class="appearance-none pl-4 pr-10 py-2.5 rounded-xl border border-slate-300 bg-white text-sm font-medium text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 cursor-pointer transition-shadow"
                            >
                                <option value="{{ route('products.index', request()->except('sort')) }}"
                                        {{ !request('sort') ? 'selected' : '' }}
                                >
                                    Sort: Latest
                                </option>
                                <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'price_asc'])) }}"
                                        {{ request('sort') === 'price_asc' ? 'selected' : '' }}
                                >
                                    Price: Low to High
                                </option>
                                <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'price_desc'])) }}"
                                        {{ request('sort') === 'price_desc' ? 'selected' : '' }}
                                >
                                    Price: High to Low
                                </option>
                                <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'name_asc'])) }}"
                                        {{ request('sort') === 'name_asc' ? 'selected' : '' }}
                                >
                                    Name: A to Z
                                </option>
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        {{-- View Toggle (Grid/List) --}}
                        <div class="hidden sm:flex items-center bg-slate-100 rounded-xl p-1" role="group" aria-label="View options">
                            <button type="button"
                                    id="grid-view-btn"
                                    class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-white transition-all aria-pressed:bg-white aria-pressed:text-indigo-600 aria-pressed:shadow-sm"
                                    aria-pressed="true"
                                    aria-label="Grid view"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                            <button type="button"
                                    id="list-view-btn"
                                    class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-white transition-all aria-pressed:bg-white aria-pressed:text-indigo-600 aria-pressed:shadow-sm"
                                    aria-pressed="false"
                                    aria-label="List view"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Products Display --}}
                @if($products->count() > 0)
                    {{-- Grid View --}}
                    <div id="grid-view" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            @include('products.partials.card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- List View (Hidden by default) --}}
                    <div id="list-view" class="hidden space-y-4">
                        @foreach($products as $product)
                            @include('products.partials.card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-10">
                        {{ $products->withQueryString()->links('vendor.pagination.tailwind') }}
                    </div>

                @else
                    {{-- Empty State --}}
                    <div class="text-center py-20 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-6">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">No products found</h3>
                        <p class="text-slate-600 mb-6 max-w-md mx-auto">
                            We couldn't find any products matching your current filters. Try adjusting your criteria or explore all categories.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors"
                            >
                                Clear all filters
                            </a>
                            <a href="{{ route('home') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium rounded-xl transition-colors"
                            >
                                Browse homepage
                            </a>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>

    {{-- Mobile Filters Overlay --}}
    <div id="mobile-filters-overlay"
         class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden hidden"
         aria-hidden="true"
    ></div>
@endsection

@push('scripts')
<script>
    /**
     * Mobile Filters Toggle
     * Handles opening/closing filters on mobile devices
     */
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-filters-toggle');
        const closeBtn = document.getElementById('close-mobile-filters');
        const filtersPanel = document.getElementById('mobile-filters');
        const overlay = document.getElementById('mobile-filters-overlay');

        function openFilters() {
            filtersPanel.classList.remove('hidden');
            filtersPanel.classList.add('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
            overlay.classList.remove('hidden');
            toggleBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }

        function closeFilters() {
            filtersPanel.classList.add('hidden');
            filtersPanel.classList.remove('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
            overlay.classList.add('hidden');
            toggleBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openFilters);
        if (closeBtn) closeBtn.addEventListener('click', closeFilters);
        if (overlay) overlay.addEventListener('click', closeFilters);

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !filtersPanel.classList.contains('hidden')) {
                closeFilters();
            }
        });

        /**
         * View Toggle: Grid/List
         */
        const gridViewBtn = document.getElementById('grid-view-btn');
        const listViewBtn = document.getElementById('list-view-btn');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');

        function setView(view) {
            if (view === 'grid') {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
                gridViewBtn.setAttribute('aria-pressed', 'true');
                listViewBtn.setAttribute('aria-pressed', 'false');
                localStorage.setItem('productView', 'grid');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
                gridViewBtn.setAttribute('aria-pressed', 'false');
                listViewBtn.setAttribute('aria-pressed', 'true');
                localStorage.setItem('productView', 'list');
            }
        }

        // Restore saved view preference
        const savedView = localStorage.getItem('productView') || 'grid';
        setView(savedView);

        if (gridViewBtn) gridViewBtn.addEventListener('click', () => setView('grid'));
        if (listViewBtn) listViewBtn.addEventListener('click', () => setView('list'));
    });
</script>
@endpush

@push('styles')
<style>
    /* Smooth transitions for view toggle */
    #grid-view, #list-view {
        transition: opacity 0.2s ease-in-out;
    }

    /* Enhanced focus states for accessibility */
    select:focus, input:focus, button:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
    }

    /* Mobile filters panel animation */
    @media (max-width: 1023px) {
        #mobile-filters:not(.hidden) {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    }
</style>
@endpush
