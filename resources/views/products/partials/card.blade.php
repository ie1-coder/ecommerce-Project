{{--
    FILE: resources/views/products/partials/card.blade.php
    PURPOSE: Reusable, secure product card component for grid view
    AUTHOR: Izzdden S. R. Alnouno
    SECURITY: XSS protection via e(), method_exists checks, data attributes for JS
--}}
@props(['product'])

<article class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2">
    <a href="{{ route('products.show', $product) }}"
       class="block focus:outline-none"
       aria-label="View details for {{ e($product->name) }}"
    >
        {{-- Product Image Container --}}
        <div class="aspect-square overflow-hidden bg-slate-50 relative">
            <img
                src="{{ e($product->image ?: 'https://via.placeholder.com/400?text=Product') }}"
                alt="{{ e($product->name) }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                loading="lazy"
                width="400"
                height="400"
                onerror="this.src='https://via.placeholder.com/400?text=Unavailable'; this.alt='Image unavailable'"
            >

            {{-- Quick Actions Overlay --}}
            <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/5 transition-colors duration-300 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto">

                {{-- Wishlist Button --}}
                <button type="button"
                        data-product-id="{{ (int) $product->id }}"
                        data-action="wishlist"
                        class="wishlist-btn p-2.5 bg-white rounded-full shadow-md text-slate-700 hover:text-indigo-600 hover:scale-110 transition transform pointer-events-auto"
                        aria-label="Add {{ e($product->name) }} to wishlist"
                        title="Add to wishlist"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

                {{-- Quick View Button --}}
                <button type="button"
                        data-product-id="{{ (int) $product->id }}"
                        data-action="quickview"
                        class="quickview-btn p-2.5 bg-white rounded-full shadow-md text-slate-700 hover:text-indigo-600 hover:scale-110 transition transform pointer-events-auto"
                        aria-label="Quick view for {{ e($product->name) }}"
                        title="Quick view"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            {{-- Badges --}}
            @if(method_exists($product, 'getDiscountPercentage') && $product->getDiscountPercentage() > 0)
                <span class="absolute top-3 left-3 px-2.5 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">
                    -{{ (int) $product->getDiscountPercentage() }}%
                </span>
            @endif

            @if(is_numeric($product->stock))
                @if($product->stock <= 5 && $product->stock > 0)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-full shadow-sm">
                        Low Stock
                    </span>
                @elseif($product->stock == 0)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-slate-800 text-white text-xs font-bold rounded-full shadow-sm">
                        Out of Stock
                    </span>
                @endif
            @endif

            @if(!empty($product->created_at) && $product->created_at->gt(now()->subDays(7)))
                <span class="absolute bottom-3 left-3 px-2.5 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full shadow-sm">
                    New
                </span>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="p-5">
            {{-- Category Tag --}}
            @if(!empty($product->category) && !empty($product->category->name))
                <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-medium rounded mb-2">
                    {{ e($product->category->name) }}
                </span>
            @endif

            {{-- Title --}}
            <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2 mb-2 min-h-[3rem]">
                {{ e($product->name) }}
            </h3>

            {{-- Description --}}
            <p class="text-sm text-slate-500 line-clamp-2 mb-4 min-h-[2.5rem]">
                {{ e(Str::limit(strip_tags($product->description ?? ''), 80)) }}
            </p>

            {{-- Rating --}}
            @if(!empty($product->rating) && is_numeric($product->rating))
                <div class="flex items-center gap-0.5 mb-3" aria-label="Rating: {{ number_format($product->rating, 1) }} out of 5">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= floor($product->rating) ? 'text-amber-400' : ($i - 0.5 <= $product->rating ? 'text-amber-400' : 'text-slate-200') }}"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             aria-hidden="true"
                        >
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    @if(!empty($product->reviews_count))
                        <span class="text-xs text-slate-500 ml-1">({{ (int) $product->reviews_count }})</span>
                    @endif
                </div>
            @endif

            {{-- Price & Stock --}}
            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <div>
                    <span class="text-lg font-bold text-slate-900">
                        {{ number_format((float) $product->price, 2) }} USD
                    </span>
                    @if(method_exists($product, 'hasDiscount') && $product->hasDiscount() && !empty($product->original_price))
                        <span class="text-sm text-slate-500 line-through ml-2">
                            {{ number_format((float) $product->original_price, 2) }}
                        </span>
                    @endif
                </div>
                <span class="text-xs font-medium {{ (is_numeric($product->stock) && $product->stock > 0) ? 'text-green-600' : 'text-red-500' }}">
                    {{ (is_numeric($product->stock) && $product->stock > 0) ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>
        </div>
    </a>
</article>

@push('scripts')
{{-- Event Delegation for Product Actions (Place in layout or page) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        e.preventDefault();
        const productId = parseInt(btn.dataset.productId, 10);
        const action = btn.dataset.action;

        if (!productId || !action) return;

        switch(action) {
            case 'wishlist':
                handleWishlist(productId, btn);
                break;
            case 'quickview':
                handleQuickView(productId);
                break;
        }
    });

    function handleWishlist(productId, btn) {
        // Implement AJAX call to add to wishlist
        console.log('Wishlist:', productId);

        // Visual feedback
        const svg = btn.querySelector('svg');
        if (svg) {
            svg.classList.toggle('text-red-500');
            svg.classList.toggle('text-slate-700');
        }

        // Optional: Show toast notification
        showToast('Added to wishlist', 'success');
    }

    function handleQuickView(productId) {
        // Implement modal load via AJAX
        console.log('Quick View:', productId);
        // Example: openModal('/products/' + productId + '/quick-view');
        showToast('Loading preview...', 'info');
    }

    function showToast(message, type = 'info') {
        // Simple toast implementation - replace with your preferred library
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-xl shadow-lg text-white text-sm font-medium z-50 animate-fade-in ${
            type === 'success' ? 'bg-green-600' :
            type === 'error' ? 'bg-red-600' : 'bg-slate-800'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
});
</script>
@endpush
