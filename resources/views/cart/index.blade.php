{{--
    FILE: resources/views/cart/index.blade.php
    PURPOSE: Display shopping cart contents with quantity management
    AUTHOR: Izzdden S. R. Alnouno
    LAST_UPDATED: 2026-03-27

    FEATURES:
    - Responsive table layout with mobile card fallback
    - Real-time quantity updates with stock validation
    - Order summary with tax calculation
    - Empty state with call-to-action
    - Session-based feedback messages
--}}

@extends('layouts.app')

@section('title', 'Shopping Cart | Professional Store')

@section('meta_description', 'Review your shopping cart items, update quantities, and proceed to secure checkout.')

@section('content')
    {{-- Page Header --}}
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="flex mb-4 text-sm" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
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
                        <span class="text-slate-900 font-semibold" aria-current="page">Shopping Cart</span>
                    </li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                Your Shopping Cart
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Session Feedback Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Empty Cart State --}}
        @if ($isEmpty ?? $cartItems->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-slate-900">Your cart is empty</h3>
                <p class="mt-2 text-slate-600">Looks like you haven't added any items yet.</p>
                <a href="{{ route('products.index') }}"
                class="mt-6 inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Cart Items Table --}}
                <div class="flex-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                        {{-- Desktop Table View --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach ($cartItems as $index => $item)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            {{-- Product Info --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-4">
                                                    <img
                                                        src="{{ $item['product']->image_url ?? 'https://via.placeholder.com/80?text=Product' }}"
                                                        alt="{{ $item['product']->name }}"
                                                        class="w-16 h-16 object-cover rounded-lg border border-slate-200"
                                                        loading="lazy"
                                                    >
                                                    <div>
                                                        <a href="{{ route('products.show', $item['product']) }}"
                                                        class="font-semibold text-slate-900 hover:text-indigo-600 transition-colors">
                                                            {{ $item['product']->name }}
                                                        </a>
                                                        @if (!$item['available'])
                                                            <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                                                Low stock
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Price --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-900 font-medium">
                                                {{ number_format($item['product']->price, 2) }} USD
                                            </td>

                                            {{-- Quantity Selector --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $index) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                                                        <button
                                                            type="submit"
                                                            name="quantity"
                                                            value="{{ max(0, $item['quantity'] - 1) }}"
                                                            class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 transition-colors disabled:opacity-50"
                                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                                            aria-label="Decrease quantity"
                                                        >
                                                            −
                                                        </button>
                                                        <span class="px-4 py-2 text-slate-900 font-medium min-w-[3rem] text-center">
                                                            {{ $item['quantity'] }}
                                                        </span>
                                                        <button
                                                            type="submit"
                                                            name="quantity"
                                                            value="{{ $item['quantity'] + 1 }}"
                                                            class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 transition-colors disabled:opacity-50"
                                                            {{ !$item['available'] ? 'disabled' : '' }}
                                                            aria-label="Increase quantity"
                                                        >
                                                            +
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>

                                            {{-- Subtotal --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-900 font-semibold">
                                                {{ number_format($item['subtotal'], 2) }} USD
                                            </td>

                                            {{-- Remove Button --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <form action="{{ route('cart.remove', $index) }}" method="POST" onsubmit="return confirm('Remove this item from cart?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-slate-400 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50"
                                                        aria-label="Remove {{ $item['product']->name }} from cart"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Card View --}}
                        <div class="md:hidden divide-y divide-slate-200">
                            @foreach ($cartItems as $index => $item)
                                <div class="p-4 space-y-4">
                                    <div class="flex gap-4">
                                        <img
                                            src="{{ $item['product']->image_url ?? 'https://via.placeholder.com/80?text=Product' }}"
                                            alt="{{ $item['product']->name }}"
                                            class="w-20 h-20 object-cover rounded-lg border border-slate-200"
                                            loading="lazy"
                                        >
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('products.show', $item['product']) }}"
                                               class="font-semibold text-slate-900 hover:text-indigo-600 transition-colors line-clamp-2">
                                                {{ $item['product']->name }}
                                            </a>
                                            <p class="mt-1 text-indigo-600 font-bold">
                                                {{ number_format($item['product']->price, 2) }} USD
                                            </p>
                                            @if (!$item['available'])
                                                <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                                    Low stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <form action="{{ route('cart.update', $index) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                                                <button type="submit" name="quantity" value="{{ max(0, $item['quantity'] - 1) }}"
                                                        class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 disabled:opacity-50"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                    −
                                                </button>
                                                <span class="px-4 py-2 text-slate-900 font-medium min-w-[3rem] text-center">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                        class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 disabled:opacity-50"
                                                        {{ !$item['available'] ? 'disabled' : '' }}>
                                                    +
                                                </button>
                                            </div>
                                        </form>

                                        <div class="text-right">
                                            <p class="font-semibold text-slate-900">
                                                {{ number_format($item['subtotal'], 2) }} USD
                                            </p>
                                            <form action="{{ route('cart.remove', $index) }}" method="POST" class="inline" onsubmit="return confirm('Remove this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Cart Actions --}}
                    <div class="mt-6 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors">
                            ← Continue Shopping
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear entire cart?');" class="sm:ml-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 text-slate-600 hover:text-red-600 font-medium transition-colors">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <aside class="lg:w-80 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-8">
                        <h2 class="text-lg font-semibold text-slate-900 mb-4">Order Summary</h2>

                        <div class="space-y-3 pb-4 border-b border-slate-200">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span class="font-medium">{{ number_format($subtotal, 2) }} USD</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Shipping</span>
                                <span class="font-medium text-emerald-600">Calculated at checkout</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Tax ({{ config('cart.tax_rate', 0.15) * 100 }}%)</span>
                                <span class="font-medium">{{ number_format($tax, 2) }} USD</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center py-4 border-b border-slate-200">
                            <span class="text-lg font-semibold text-slate-900">Total</span>
                            <span class="text-2xl font-extrabold text-slate-900">
                                {{ number_format($total, 2) }} USD
                            </span>
                        </div>

                        {{-- Checkout Button --}}
                        <button
                            type="button"
                            class="w-full mt-4 px-6 py-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-lg rounded-xl transition-all shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
                            disabled
                            title="Checkout functionality coming soon"
                        >
                            Proceed to Checkout
                        </button>

                        <p class="mt-3 text-xs text-slate-500 text-center">
                            Secure checkout with SSL encryption
                        </p>

                        {{-- Trust Badges --}}
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-center gap-4 text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </div>
@endsection
