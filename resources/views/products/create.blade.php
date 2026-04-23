{{--
    FILE: resources/views/products/create.blade.php
    PURPOSE: Admin form for creating new products
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27

    FEATURES:
    - Real-time image preview
    - Dynamic specifications fields
    - Client-side validation hints
    - CSRF protection and error display
    - Responsive two-column layout
--}}

@extends('layouts.app')

@section('title', 'Create New Product | Admin Panel')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-8">
                <nav class="flex mb-4 text-sm" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('home') }}" class="text-slate-600 hover:text-indigo-600">Home</a></li>
                        <li><svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></li>
                        <li><a href="{{ route('products.index') }}" class="text-slate-600 hover:text-indigo-600">Products</a></li>
                        <li><svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg></li>
                        <li><span class="text-slate-900 font-semibold" aria-current="page">Create New</span></li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-slate-900">Create New Product</h1>
                <p class="mt-2 text-slate-600">Fill in the details below to add a new product to your catalog.</p>
            </div>

            {{-- Form Container --}}
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Main Content Column --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Basic Information Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900 mb-6">Basic Information</h2>

                            <div class="space-y-5">
                                {{-- Product Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                                        Product Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        required
                                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror"
                                        placeholder="Enter product name"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Category --}}
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        name="category_id"
                                        id="category_id"
                                        required
                                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-red-300 @enderror"
                                    >
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div>
                                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        name="description"
                                        id="description"
                                        rows="5"
                                        required
                                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror"
                                        placeholder="Enter detailed product description"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Pricing & Inventory Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900 mb-6">Pricing & Inventory</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                {{-- Price --}}
                                <div>
                                    <label for="price" class="block text-sm font-medium text-slate-700 mb-1">
                                        Price (USD) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                                        <input
                                            type="number"
                                            name="price"
                                            id="price"
                                            value="{{ old('price') }}"
                                            step="0.01"
                                            min="0"
                                            required
                                            class="w-full pl-8 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('price') border-red-300 @enderror"
                                            placeholder="0.00"
                                        >
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Original Price (for discounts) --}}
                                <div>
                                    <label for="original_price" class="block text-sm font-medium text-slate-700 mb-1">
                                        Original Price <span class="text-slate-400">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                                        <input
                                            type="number"
                                            name="original_price"
                                            id="original_price"
                                            value="{{ old('original_price') }}"
                                            step="0.01"
                                            min="0"
                                            class="w-full pl-8 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('original_price') border-red-300 @enderror"
                                            placeholder="0.00"
                                        >
                                    </div>
                                    @error('original_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Set higher than price to show discount</p>
                                </div>

                                {{-- Stock Quantity --}}
                                <div>
                                    <label for="stock" class="block text-sm font-medium text-slate-700 mb-1">
                                        Stock Quantity <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="stock"
                                        id="stock"
                                        value="{{ old('stock', 0) }}"
                                        min="0"
                                        required
                                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('stock') border-red-300 @enderror"
                                        placeholder="0"
                                    >
                                    @error('stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Specifications Card (Dynamic Fields) --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-slate-900">Specifications</h2>
                                <button
                                    type="button"
                                    id="add-spec-btn"
                                    class="text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                                >
                                    + Add Specification
                                </button>
                            </div>

                            <div id="specifications-container" class="space-y-3">
                                @if(old('specifications'))
                                    @foreach(old('specifications') as $key => $value)
                                        <div class="flex gap-3">
                                            <input type="text" name="specifications[{{ $key }}]" value="{{ $key }}"
                                                   placeholder="Key (e.g., Weight)"
                                                   class="flex-1 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <input type="text" name="specifications[{{ $key }}]" value="{{ $value }}"
                                                   placeholder="Value (e.g., 2.5 kg)"
                                                   class="flex-1 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" class="remove-spec text-red-500 hover:text-red-700">×</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex gap-3">
                                        <input type="text" name="specifications[key][]" placeholder="Key"
                                               class="flex-1 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <input type="text" name="specifications[value][]" placeholder="Value"
                                               class="flex-1 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="button" class="remove-spec text-red-500 hover:text-red-700">×</button>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- Sidebar Column --}}
                    <div class="space-y-6">

                        {{-- Product Image Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900 mb-4">Product Image</h2>

                            {{-- Image Preview --}}
                            <div class="mb-4">
                                <div id="image-preview-container" class="aspect-square rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden">
                                    <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                                    <div id="image-placeholder" class="text-center p-4">
                                        <svg class="mx-auto h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-slate-500">No image selected</p>
                                    </div>
                                </div>
                            </div>

                            {{-- File Input --}}
                            <label for="image" class="block">
                                <span class="sr-only">Choose product image</span>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                >
                            </label>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-slate-500">Recommended: 800x800px, max 2MB</p>
                        </div>

                        {{-- Form Actions --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-8">
                            <div class="flex flex-col gap-3">
                                <button
                                    type="submit"
                                    class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Create Product
                                </button>
                                <a href="{{ route('products.index') }}"
                                   class="w-full px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-colors text-center">
                                    Cancel
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Image Preview Functionality
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');
            const imagePlaceholder = document.getElementById('image-placeholder');

            imageInput?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        imagePreview.classList.remove('hidden');
                        imagePlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Dynamic Specifications Fields
            const specsContainer = document.getElementById('specifications-container');
            const addSpecBtn = document.getElementById('add-spec-btn');
            let specIndex = 1;

            addSpecBtn?.addEventListener('click', () => {
                const specRow = document.createElement('div');
                specRow.className = 'flex gap-3';
                specRow.innerHTML = `
                    <input type="text" name="specifications[key][]" placeholder="Key"
                        class="flex-1 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="text" name="specifications[value][]" placeholder="Value"
                        class="flex-1 rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="button" class="remove-spec text-red-500 hover:text-red-700">×</button>
                `;
                specsContainer.appendChild(specRow);
            });

            specsContainer?.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-spec')) {
                    e.target.closest('.flex').remove();
                }
            });
        });
    </script>
@endsection
