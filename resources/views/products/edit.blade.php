{{--
    KEY DIFFERENCES FROM CREATE VIEW:
    1. Form action: route('products.update', $product) with @method('PUT')
    2. Input values: prefilled with $product->property
    3. Image section: shows current image with option to replace
    4. Page title: "Edit Product" instead of "Create"
--}}

@extends('layouts.app')
@section('title', 'Edit Product | Admin Panel')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Edit Product</h1>
                <p class="mt-2 text-slate-600">Update details for: <span class="font-semibold">{{ $product->name }}</span></p>
            </div>

            {{-- Form with PUT method --}}
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT') {{-- Critical: Tells Laravel this is an update request --}}

                {{-- Rest of the form mirrors create.blade.php with these key changes: --}}

                {{-- Example: Prefilled name field --}}
                <input type="text" name="name" value="{{ old('name', $product->name) }}" ... >

                {{-- Example: Prefilled category --}}
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>

                {{-- Example: Current image display --}}
                @if($product->image)
                    <div class="mb-4">
                        <p class="text-sm font-medium text-slate-700 mb-2">Current Image</p>
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            class="w-32 h-32 object-cover rounded-lg border border-slate-200">
                    </div>
                @endif

                {{-- Submit button text changed --}}
                <button type="submit">Update Product</button>

            </form>
        </div>
    </div>
@endsection
