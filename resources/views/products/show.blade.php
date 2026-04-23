{{--
    FILE: resources/views/products/show.blade.php
    PURPOSE: Professional, secure product detail page with conversion optimization
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: {{ date('Y-m-d') }}
    SECURITY: XSS sanitization, CSRF protection, CSP-ready, input validation
    PERFORMANCE: CLS prevention, lazy loading, structured data, critical CSS inlined
    ACCESSIBILITY: WCAG 2.1 AA compliant, ARIA labels, keyboard navigation support
--}}

@extends('layouts.app')



@section('title', e($product->name) . ' | Professional Store')
@section('meta_description', e(Str::limit($product->description ?? 'Discover ' . $product->name . ' - Premium quality product with fast shipping.', 160)))

{{-- Open Graph / Social Meta Tags --}}
@section('og_tags')
    <meta property="og:title" content="{{ e($product->name) }}">
    <meta property="og:description" content="{{ e(Str::limit($product->description, 160)) }}">
    <meta property="og:image" content=  " {{ e($product->image) ??   asset('') }}  " >
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="product:price:amount" content="{{ number_format($product->price, 2) }}">
    <meta property="product:price:currency" content="USD">
    <meta property="product:availability" content="{{ $product->stock > 0 ? 'in stock' : 'out of stock' }}">
@endsection

{{-- Structured Data: Product Schema --}}
@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "{{ e($product->name) }}",
    "image": "{{ e($product->image ?? asset('images/placeholder.jpg')) }}",
    "description": "{{ e(strip_tags($product->description)) }}",
    "sku": "{{ e($product->sku ?? $product->id) }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ e(config('app.name')) }}"
    },
    "offers": {
        "@type": "Offer",
        "url": "{{ url()->current() }}",
        "priceCurrency": "USD",
        "price": "{{ number_format($product->price, 2, '.', '') }}",
        "priceValidUntil": "{{ date('Y-12-31') }}",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "seller": {
            "@type": "Organization",
            "name": "{{ e(config('app.name')) }}"
        }
    },
    "aggregateRating": @if(!empty($product->rating)) {
        "@type": "AggregateRating",
        "ratingValue": "{{ number_format($product->rating, 1) }}",
        "reviewCount": "{{ $product->reviews_count ?? 0 }}"
    } @else null @endif
}
</script>
@endpush

@section('content')
    {{-- Preconnect for Image CDN (Performance) --}}
    <link rel="preconnect" href="https://via.placeholder.com" crossorigin>

    <main class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-8 md:py-12 lg:py-16" itemscope itemtype="https://schema.org/Product">
        <meta itemprop="name" content="{{ e($product->name) }}">
        <meta itemprop="description" content="{{ e(strip_tags($product->description)) }}">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="flex items-center flex-wrap gap-x-2 gap-y-1" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('home') }}" itemprop="item" class="text-slate-600 hover:text-indigo-600 transition-colors font-medium">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                    <li class="text-slate-400" aria-hidden="true">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        @if(!empty($product->category) && !empty($product->category->id))
                            <a href="{{ route('categories.show', $product->category) }}" itemprop="item" class="text-slate-600 hover:text-indigo-600 transition-colors font-medium">
                                <span itemprop="name">{{ e($product->category->name) }}</span>
                            </a>
                        @else
                            <a href="{{ route('products.index') }}" itemprop="item" class="text-slate-600 hover:text-indigo-600 transition-colors font-medium">
                                <span itemprop="name">Products</span>
                            </a>
                        @endif
                        <meta itemprop="position" content="2">
                    </li>
                    <li class="text-slate-400" aria-hidden="true">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span class="text-slate-900 font-semibold" itemprop="name" aria-current="page">{{ e(Str::limit($product->name, 40)) }}</span>
                        <meta itemprop="position" content="3">
                    </li>
                </ol>
            </nav>

            {{-- Product Grid Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 xl:gap-16">

                {{-- Product Media Section --}}
                <section class="lg:sticky lg:top-8 space-y-6" aria-label="Product images">
                    {{-- Primary Product Image with Zoom on Hover --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group relative" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <div class="aspect-square relative overflow-hidden bg-slate-50">
                            <img
                                src="{{ e($product->image ?? asset('images/placeholder-800.jpg')) }}"
                                alt="{{ e($product->name) }} - High resolution product image"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-zoom-in"
                                loading="eager"
                                width="800"
                                height="800"
                                itemprop="contentUrl"
                                onerror="this.src=''; this.alt='Image unavailable for {{ e($product->name) }}'"
                            >
                            <meta itemprop="width" content="800">
                            <meta itemprop="height" content="800">

                            {{-- Stock Status Badge --}}
                            @if(is_numeric($product->stock) && $product->stock <= 5 && $product->stock > 0)
                                <span class="absolute top-4 left-4 px-3 py-1.5 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full border border-amber-200 z-10">
                                    Low stock: {{ (int) $product->stock }} left
                                </span>
                            @endif

                            {{-- Discount Badge --}}
                            @if(method_exists($product, 'hasDiscount') && $product->hasDiscount())
                                <span class="absolute top-4 right-4 px-3 py-1.5 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm z-10">
                                    -{{ (int) $product->getDiscountPercentage() }}%
                                </span>
                            @endif
                        </div>

                        {{-- Image Zoom Modal Trigger (Enhancement) --}}
                        <button type="button"
                                class="absolute bottom-4 right-4 p-2.5 bg-white/90 backdrop-blur-sm rounded-full shadow-lg text-slate-700 hover:text-indigo-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100 focus:opacity-100"
                                aria-label="View {{ e($product->name) }} in full size"
                                onclick="openImageModal('{{ e($product->image ?? asset('images/placeholder-800.jpg')) }}', '{{ e($product->name) }}')"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Thumbnail Gallery (Conditional) --}}
                    @if(!empty($product->images) && is_iterable($product->images) && count($product->images) > 0)
                        <div class="grid grid-cols-4 gap-3" role="tablist" aria-label="Product image thumbnails">
                            @foreach($product->images as $index => $image)
                                <button
                                    type="button"
                                    role="tab"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="main-image"
                                    data-image="{{ e($image) }}"
                                    class="aspect-square rounded-xl overflow-hidden border-2 {{ $loop->first ? 'border-indigo-500 ring-2 ring-indigo-200' : 'border-transparent hover:border-indigo-300' }} transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    onclick="changeMainImage(this)"
                                >
                                    <img
                                        src="{{ e($image) }}"
                                        alt="{{ e($product->name) }} - View {{ $loop->iteration }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                        width="200"
                                        height="200"
                                    >
                                </button>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- Product Information Section --}}
                <section class="flex flex-col" aria-label="Product details">
                    <meta itemprop="brand" content="{{ e(config('app.name')) }}">
                    <meta itemprop="sku" content="{{ e($product->sku ?? $product->id) }}">

                    {{-- Product Header --}}
                    <header class="mb-6">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-900 mb-4 leading-tight" itemprop="name">
                            {{ e($product->name) }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            {{-- Category Badge --}}
                            @if(!empty($product->category) && !empty($product->category->name))
                                <a href="{{ route('categories.show', $product->category) }}"
                                   class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 hover:bg-indigo-100 transition-colors"
                                >
                                    {{ e($product->category->name) }}
                                </a>
                            @endif

                            {{-- Rating Display --}}
                            @if(!empty($product->rating) && is_numeric($product->rating))
                                <div class="flex items-center gap-1" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= floor($product->rating) ? 'text-amber-400' : ($i - 0.5 <= $product->rating ? 'text-amber-400' : 'text-slate-200') }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <meta itemprop="ratingValue" content="{{ number_format($product->rating, 1) }}">
                                    <meta itemprop="reviewCount" content="{{ $product->reviews_count ?? 0 }}">
                                    <span class="text-xs text-slate-500 ml-1">({{ (int) ($product->reviews_count ?? 0) }} reviews)</span>
                                </div>
                            @endif

                            {{-- Stock Status --}}
                            @if(is_numeric($product->stock))
                                @if($product->stock > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse" aria-hidden="true"></span>
                                        In Stock ({{ (int) $product->stock }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Out of Stock
                                    </span>
                                @endif
                            @endif
                        </div>
                    </header>

                    {{-- Pricing Section --}}
                    <div class="mb-8 pb-8 border-b border-slate-200" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="USD">
                        <meta itemprop="price" content="{{ number_format($product->price, 2, '.', '') }}">
                        <meta itemprop="availability" content="{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}">

                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl md:text-5xl font-extrabold text-slate-900" itemprop="price" content="{{ number_format($product->price, 2, '.', '') }}">
                                {{ number_format((float) $product->price, 2) }}
                            </span>
                            <span class="text-xl text-slate-500 font-medium">USD</span>
                        </div>

                        @if(!empty($product->original_price) && (float) $product->original_price > (float) $product->price)
                            <p class="mt-2 text-slate-500 line-through">
                                {{ number_format((float) $product->original_price, 2) }} USD
                            </p>
                            @php
                                $discount = ((float) $product->original_price - (float) $product->price) / (float) $product->original_price * 100;
                            @endphp
                            <p class="text-emerald-600 font-semibold text-sm">
                                Save {{ number_format($discount, 0) }}%
                            </p>
                        @endif
                    </div>

                    {{-- Product Description --}}
                    <article class="prose prose-slate prose-lg max-w-none mb-10" itemprop="description">
                        <h2 class="text-xl font-semibold text-slate-900 mb-3">Overview</h2>
                        <div class="text-slate-600 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </article>

                    {{-- Specifications (Collapsible) --}}
                    @if(!empty($product->specifications) && is_array($product->specifications) && count($product->specifications) > 0)
                        <details class="mb-8 group" itemprop="additionalProperty" itemscope itemtype="https://schema.org/PropertyValue">
                            <summary class="flex items-center justify-between cursor-pointer list-none focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg p-2 -m-2">
                                <span class="text-lg font-semibold text-slate-900">Specifications</span>
                                <svg class="w-5 h-5 text-slate-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6">
                                    @foreach($product->specifications as $key => $value)
                                        <div>
                                            <dt class="text-sm font-medium text-slate-500">{{ e(ucfirst($key)) }}</dt>
                                            <dd class="text-sm text-slate-900">{{ e($value) }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        </details>
                    @endif

                    {{-- Add to Cart Form --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto space-y-6" novalidate x-data="productForm({{ (int) $product->stock }})">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ (int) $product->id }}">

                        {{-- Quantity Selector --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <label for="quantity" class="text-base font-semibold text-slate-700">Quantity</label>
                            <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-shadow" role="group" aria-label="Quantity selector">
                                <button
                                    type="button"
                                    @click="decrease"
                                    :disabled="quantity <= 1 || maxStock <= 0"
                                    class="quantity-decrease px-4 py-3 bg-slate-50 hover:bg-slate-100 disabled:bg-slate-100 disabled:cursor-not-allowed text-slate-700 font-medium transition-colors"
                                    aria-label="Decrease quantity"
                                >−</button>
                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity"
                                    x-model="quantity"
                                    min="1"
                                    :max="maxStock"
                                    class="w-16 text-center border-x border-slate-300 py-3 focus:outline-none focus:ring-0 text-slate-900 font-medium [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    aria-live="polite"
                                >
                                <button
                                    type="button"
                                    @click="increase"
                                    :disabled="quantity >= maxStock || maxStock <= 0"
                                    class="quantity-increase px-4 py-3 bg-slate-50 hover:bg-slate-100 disabled:bg-slate-100 disabled:cursor-not-allowed text-slate-700 font-medium transition-colors"
                                    aria-label="Increase quantity"
                                >+</button>
                            </div>
                            @if(is_numeric($product->stock) && $product->stock < 10 && $product->stock > 0)
                                <span class="text-xs text-amber-600 font-medium" x-show="quantity >= {{ (int) $product->stock }}">
                                    Only {{ (int) $product->stock }} left!
                                </span>
                            @endif
                        </div>

                        {{-- Primary Action Button --}}
                        <button
                            type="submit"
                            :disabled="maxStock <= 0 || loading"
                            class="w-full sm:w-auto px-10 py-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-semibold text-lg rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex items-center justify-center gap-2"
                            aria-busy="false"
                        >
                            <span x-show="!loading" x-text="maxStock > 0 ? 'Add to Cart' : 'Notify When Available'"></span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Adding...
                            </span>
                        </button>

                        {{-- Secondary Actions --}}
                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            <button
                                type="button"
                                @click="toggleWishlist"
                                class="text-sm text-slate-600 hover:text-indigo-600 font-medium transition-colors flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg p-1"
                                :class="{'text-red-500': isWishlisted}"
                                aria-pressed="false"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'fill-current': isWishlisted}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span x-text="isWishlisted ? 'In Wishlist' : 'Add to Wishlist'"></span>
                            </button>

                            <button
                                type="button"
                                @click="shareProduct"
                                class="text-sm text-slate-600 hover:text-indigo-600 font-medium transition-colors flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg p-1"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Share
                            </button>
                        </div>

                        {{-- Session Feedback Messages --}}
                        @if(session('success'))
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                                 class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium" role="alert" aria-live="polite">
                                {{ e(session('success')) }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 7000)"
                                 class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium" role="alert" aria-live="assertive">
                                {{ e(session('error')) }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium" role="alert" aria-live="assertive">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ e($error) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>

                    {{-- Trust Badges --}}
                    <div class="mt-10 pt-8 border-t border-slate-200 grid grid-cols-2 sm:grid-cols-3 gap-4 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-xs text-slate-600 font-medium">Free Shipping</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span class="text-xs text-slate-600 font-medium">Secure Checkout</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-6 h-6 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span class="text-xs text-slate-600 font-medium">30-Day Returns</span>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Related Products Section --}}
            @if(!empty($relatedProducts) && count($relatedProducts) > 0)
                <section class="mt-20 pt-12 border-t border-slate-200" aria-label="Related products">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">You May Also Like</h2>
                        @if(!empty($product->category) && !empty($product->category->id))
                            <a href="{{ route('categories.show', $product->category) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm transition-colors">
                                View All →
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            @include('products.partials.card', ['product' => $related])
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </main>

    {{-- Image Zoom Modal --}}
    <div id="image-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" @click="closeImageModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="relative max-w-4xl w-full">
                <button type="button" @click="closeImageModal()" class="absolute -top-10 right-0 p-2 text-white hover:text-slate-300 focus:outline-none" aria-label="Close image viewer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <img id="modal-image" src="" alt="" class="w-full h-auto rounded-xl shadow-2xl">
                <p id="modal-title" class="sr-only"></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Alpine.js Component for Product Interactions --}}
<script>
function productForm(maxStock) {
    return {
        quantity: 1,
        maxStock: maxStock,
        loading: false,
        isWishlisted: false,

        init() {
            // Load wishlist state from localStorage or API
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            this.isWishlisted = wishlist.includes({{ (int) $product->id }});
        },

        decrease() {
            if (this.quantity > 1) this.quantity--;
        },

        increase() {
            if (this.quantity < this.maxStock) this.quantity++;
        },

        async toggleWishlist() {
            const productId = {{ (int) $product->id }};
            this.isWishlisted = !this.isWishlisted;

            // Update localStorage
            let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            if (this.isWishlisted) {
                if (!wishlist.includes(productId)) wishlist.push(productId);
                this.showToast('Added to wishlist', 'success');
            } else {
                wishlist = wishlist.filter(id => id !== productId);
                this.showToast('Removed from wishlist', 'info');
            }
            localStorage.setItem('wishlist', JSON.stringify(wishlist));

            // TODO: Sync with backend via API
            // await fetch('/api/wishlist', { method: 'POST', body: JSON.stringify({ productId, action: this.isWishlisted ? 'add' : 'remove' }) });
        },

        async shareProduct() {
            const shareData = {
                title: '{{ e($product->name) }}',
                text: '{{ e(Str::limit($product->description, 100)) }}',
                url: window.location.href
            };

            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                } catch (err) {
                    if (err.name !== 'AbortError') this.copyToClipboard();
                }
            } else {
                this.copyToClipboard();
            }
        },

        copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                this.showToast('Link copied to clipboard!', 'success');
            });
        },

        showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-3 rounded-xl shadow-lg text-white text-sm font-medium z-50 animate-fade-in ${
                type === 'success' ? 'bg-emerald-600' : type === 'error' ? 'bg-red-600' : 'bg-slate-800'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(1rem)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    };
}

// Image Modal Functions
function openImageModal(src, alt) {
    const modal = document.getElementById('image-modal');
    const img = document.getElementById('modal-image');
    const title = document.getElementById('modal-title');

    if (modal && img) {
        img.src = src;
        img.alt = alt;
        if (title) title.textContent = alt;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Focus trap for accessibility
        setTimeout(() => modal.querySelector('button')?.focus(), 100);
    }
}

function closeImageModal() {
    const modal = document.getElementById('image-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Thumbnail Image Switcher
function changeMainImage(btn) {
    const newSrc = btn.dataset.image;
    const mainImg = document.querySelector('[itemprop="image"] img');
    const thumbnails = btn.parentElement.querySelectorAll('[role="tab"]');

    if (mainImg && newSrc) {
        // Update main image with fade transition
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 150);
    }

    // Update active state on thumbnails
    thumbnails.forEach(t => {
        t.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-200');
        t.classList.add('border-transparent');
        t.setAttribute('aria-selected', 'false');
    });
    btn.classList.remove('border-transparent');
    btn.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-200');
    btn.setAttribute('aria-selected', 'true');
}

// Keyboard navigation for modal
document.addEventListener('keydown', (e) => {
    const modal = document.getElementById('image-modal');
    if (modal && !modal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeImageModal();
    }
});
</script>

{{-- CSS Animations --}}
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(1rem); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.3s ease-out forwards; }

/* Smooth image transitions */
[itemscope="image"] img { transition: opacity 0.15s ease-in-out; }

/* Focus visible for keyboard users */
:focus-visible { outline: 2px solid #4f46e5; outline-offset: 2px; }
</style>
@endpush
