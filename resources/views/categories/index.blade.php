{{--
    FILE: resources/views/categories/index.blade.php
    PURPOSE: Display all product categories with counts and descriptions
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27

    FEATURES:
    - Grid layout with category cards
    - Product count per category
    - Category descriptions
    - Hover effects and animations
    - Responsive design
    - Search and filter capabilities
    - Breadcrumb navigation
--}}

@extends('layouts.app')

@section('title', 'All Categories | Professional Store')

@section('meta_description', 'Browse all product categories at Professional Store. Find exactly what you\'re looking for from our wide range of categories.')

@section('content')
    {{-- Page Header with Hero Section --}}
    <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-900 text-white py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <nav class="flex mb-6 text-sm text-indigo-200" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                        </li>
                        <li>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li>
                        <li>
                            <span class="text-white font-semibold" aria-current="page">Categories</span>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Shop by Category
                </h1>
                <p class="text-xl text-indigo-100 mb-8">
                    Explore our wide range of product categories and find exactly what you're looking for
                </p>

                {{-- Search Bar --}}
                <div class="relative max-w-xl">
                    <input
                        type="text"
                        id="categorySearch"
                        placeholder="Search categories..."
                        class="w-full px-6 py-4 rounded-xl text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-indigo-400 shadow-2xl"
                    >
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">

        {{-- Stats Bar --}}
        <div class="mb-10 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $categories->count() }}</p>
                    <p class="text-sm text-slate-600">Total Categories</p>
                </div>
            </div>

            {{-- Sort Options --}}
            <div class="flex items-center gap-3">
                <label for="sortBy" class="text-sm font-medium text-slate-700">Sort by:</label>
                <select id="sortBy" class="px-4 py-2 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="name">Name (A-Z)</option>
                    <option value="products">Most Products</option>
                    <option value="newest">Newest First</option>
                </select>
            </div>
        </div>

        {{-- Categories Grid --}}
        @if ($categories->count() > 0)
            <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                    class="category-card group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2"
                    data-name="{{ strtolower($category->name) }}"
                    data-products="{{ $category->products_count ?? 0 }}"
                    data-created="{{ $category->created_at->timestamp }}"
                    >
                        {{-- Category Image/Icon --}}
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600">
                            @if ($category->image)
                                <img src="{{ $category->image }}"
                                    alt="{{ $category->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- Product Count Badge --}}
                            <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-full">
                                <span class="text-sm font-bold text-indigo-600">
                                    {{ $category->products_count ?? 0 }}
                                </span>
                                <span class="text-xs text-slate-600 ml-1">products</span>
                            </div>

                            {{-- Overlay on Hover --}}
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                        </div>

                        {{-- Category Info --}}
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                {{ $category->name }}
                            </h3>

                            @if ($category->description)
                                <p class="text-slate-600 text-sm line-clamp-2 mb-4">
                                    {{ Str::limit($category->description, 100) }}
                                </p>
                            @else
                                <p class="text-slate-400 text-sm mb-4">
                                    Browse our collection of {{ strtolower($category->name) }} products
                                </p>
                            @endif

                            {{-- View Link --}}
                            <div class="flex items-center gap-2 text-indigo-600 font-semibold text-sm group-hover:gap-3 transition-all">
                                <span>View Products</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- No Results Message --}}
            <div id="noResults" class="hidden text-center py-16">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-slate-900">No categories found</h3>
                <p class="mt-2 text-slate-600">Try adjusting your search terms</p>
            </div>

        @else
            {{-- Empty State --}}
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-slate-900">No categories available</h3>
                <p class="mt-2 text-slate-600">Check back soon for new categories</p>
                <a href="{{ route('products.index') }}"
                class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors">
                    Browse All Products
                </a>
            </div>
        @endif

        {{-- Popular Categories Section --}}
        @if ($categories->count() > 0)
            <div class="mt-20 pt-12 border-t border-slate-200">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-8 text-center">
                    Popular Categories
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($categories->sortByDesc('products_count')->take(6) as $category)
                        <a href="{{ route('categories.show', $category) }}"
                           class="group flex flex-col items-center p-6 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition-all duration-300 hover:shadow-lg">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-slate-900 text-center group-hover:text-indigo-600 transition-colors">
                                {{ $category->name }}
                            </h4>
                            <p class="text-sm text-slate-600 mt-1">
                                {{ $category->products_count ?? 0 }} products
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        /**
         * Category Search and Filter Functionality
         */
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('categorySearch');
            const categoriesGrid = document.getElementById('categoriesGrid');
            const noResults = document.getElementById('noResults');
            const sortBySelect = document.getElementById('sortBy');
            const categoryCards = document.querySelectorAll('.category-card');

            /**
             * Filter categories based on search query
             */
            const filterCategories = () => {
                const query = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                categoryCards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    const matches = name.includes(query);

                    if (matches) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (categoriesGrid) {
                    if (visibleCount === 0) {
                        categoriesGrid.style.display = 'none';
                        noResults.classList.remove('hidden');
                    } else {
                        categoriesGrid.style.display = 'grid';
                        noResults.classList.add('hidden');
                    }
                }
            };

            /**
             * Sort categories
             */
            const sortCategories = () => {
                const sortBy = sortBySelect.value;
                const cards = Array.from(categoryCards);

                cards.sort((a, b) => {
                    switch(sortBy) {
                        case 'name':
                            return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));

                        case 'products':
                            return parseInt(b.getAttribute('data-products')) - parseInt(a.getAttribute('data-products'));

                        case 'newest':
                            return parseInt(b.getAttribute('data-created')) - parseInt(a.getAttribute('data-created'));

                        default:
                            return 0;
                    }
                });

                // Re-append sorted cards
                cards.forEach(card => categoriesGrid.appendChild(card));
            };

            // Event Listeners
            if (searchInput) {
                searchInput.addEventListener('input', filterCategories);
            }

            if (sortBySelect) {
                sortBySelect.addEventListener('change', sortCategories);
            }

            // Add smooth scroll to top when clicking on category
            categoryCards.forEach(card => {
                card.addEventListener('click', (e) => {
                    if (!e.ctrlKey && !e.metaKey) {
                        e.preventDefault();
                        const href = card.getAttribute('href');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        setTimeout(() => {
                            window.location.href = href;
                        }, 300);
                    }
                });
            });
        });
    </script>
@endsection
