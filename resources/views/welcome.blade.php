{{--
    FILE: resources/views/welcome.blade.php
    PURPOSE: Professional e-commerce homepage with hero section and featured products
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27

    FEATURES:
    - Hero section with call-to-action
    - Featured categories
    - Featured products showcase
    - Promotional banners
    - Newsletter subscription
    - Trust badges and testimonials
    - Fully responsive design
--}}

@extends('layouts.app')

@section('title', 'Professional E-Commerce Store | Home')

@section('meta_description', 'Discover premium products at competitive prices. Fast shipping, secure checkout, and exceptional customer service.')

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-900 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 lg:py-36">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Hero Content --}}
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        Discover Premium
                        <span class="block text-indigo-200">Products Online</span>
                    </h1>
                    <p class="text-lg md:text-xl text-indigo-100 mb-8 max-w-2xl mx-auto lg:mx-0">
                        Shop the latest trends with confidence. Quality products, competitive prices, and fast delivery right to your doorstep.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('products.index') }}"
                        class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            Shop Now
                        </a>
                        <a href="#features"
                        class="px-8 py-4 bg-indigo-800 text-white font-bold rounded-2xl hover:bg-indigo-900 transition-all border-2 border-indigo-600">
                            Learn More
                        </a>
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="mt-10 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-indigo-200 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Free Shipping</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                            </svg>
                            <span>Secure Payment</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>

                {{-- Hero Image/Illustration --}}
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-3xl transform rotate-3 opacity-20"></div>
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop"
                            alt="Shopping Illustration"
                            class="relative rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Why Choose Us</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">We provide the best shopping experience with premium features</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Feature 1 --}}
                <div class="group p-6 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition-all duration-300 hover:shadow-xl">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Free Shipping</h3>
                    <p class="text-slate-600">Free shipping on all orders over $50. Fast and reliable delivery.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="group p-6 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition-all duration-300 hover:shadow-xl">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Secure Payment</h3>
                    <p class="text-slate-600">100% secure payment methods. Your data is always protected.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="group p-6 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition-all duration-300 hover:shadow-xl">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Easy Returns</h3>
                    <p class="text-slate-600">30-day hassle-free return policy. Shop with confidence.</p>
                </div>

                {{-- Feature 4 --}}
                <div class="group p-6 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition-all duration-300 hover:shadow-xl">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">24/7 Support</h3>
                    <p class="text-slate-600">Round-the-clock customer support. We're here to help.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Categories --}}
    <section class="py-16 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Shop by Category</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Explore our wide range of product categories</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $categories = [
                        ['name' => 'Electronics', 'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'bg-blue-500'],
                        ['name' => 'Fashion', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'color' => 'bg-purple-500'],
                        ['name' => 'Home & Living', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'color' => 'bg-emerald-500'],
                        ['name' => 'Sports', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064', 'color' => 'bg-orange-500'],
                    ];
                @endphp

                @foreach($categories as $category)
                    <a href="{{ route('products.index') }}"
                    class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 text-center">
                        <div class="w-16 h-16 {{ $category['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $category['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors">
                            {{ $category['name'] }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Products Section --}}
    <section class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Featured Products</h2>
                    <p class="text-lg text-slate-600">Handpicked selections just for you</p>
                </div>
                <a href="{{ route('products.index') }}"
                class="hidden md:inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold transition-colors">
                    View All
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            {{-- Products Grid - Will be populated dynamically --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 0; $i < 4; $i++)
                    <div class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="aspect-square overflow-hidden bg-slate-50 relative">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop"
                                alt="Product"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 left-3 px-2.5 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                -20%
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2 mb-2">
                                Premium Wireless Headphones
                            </h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-lg font-bold text-slate-900">$99.99</span>
                                    <span class="text-sm text-slate-500 line-through ml-2">$124.99</span>
                                </div>
                            </div>
                            <button class="mt-4 w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('products.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors">
                    View All Products
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Newsletter Section --}}
    <section class="py-16 md:py-20 bg-gradient-to-r from-indigo-600 to-indigo-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Subscribe to Our Newsletter</h2>
            <p class="text-lg text-indigo-100 mb-8">Get exclusive deals, new arrivals, and insider-only discounts</p>

            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email"
                    placeholder="Enter your email"
                    class="flex-1 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-white text-slate-900"
                    required>
                <button type="submit"
                        class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">
                    Subscribe
                </button>
            </form>

            <p class="mt-4 text-sm text-indigo-200">No spam, unsubscribe at any time.</p>
        </div>
    </section>
@endsection
