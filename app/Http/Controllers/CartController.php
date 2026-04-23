<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class CartController
 *
 * Manages shopping cart operations including:
 * - Viewing cart contents
 * - Adding items with quantity validation
 * - Updating item quantities
 * - Removing items individually or clearing entire cart
 *
 * Cart data is stored in session for guest users.
 * For authenticated users, consider migrating to database persistence.
 *
 * @package App\Http\Controllers
 */
class CartController extends Controller
{
    /**
     * Session key for cart storage.
     *
     * @var string
     */
    protected const CART_SESSION_KEY = 'shopping_cart';

    /**
     * Display the shopping cart contents.
     *
     * Features:
     * - Retrieves cart items from session
     * - Eager loads product data for display
     * - Calculates subtotal, tax, and total
     * - Handles out-of-stock validation
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve cart from session or initialize empty array
        $cart = Session::get(self::CART_SESSION_KEY, []);

        // If cart is empty, return view with empty state
        if (empty($cart)) {
            return view('cart.index', [
                'cartItems' => [],
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'isEmpty' => true
            ]);
        }

        // Build collection of cart items with product data
        $cartItems = collect($cart)->map(function ($item) {
            $product = Product::find($item['product_id']);

            // Handle case where product may have been deleted
            if (!$product) {
                return null;
            }

            return [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $product->price * $item['quantity'],
                'available' => $product->stock >= $item['quantity'],
            ];
        })->filter()->values();

        // Calculate order totals
        $subtotal = $cartItems->sum('subtotal');
        $taxRate = config('cart.tax_rate', 0.15); // 15% default tax
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    /**
     * Add a product to the shopping cart.
     *
     * Validation:
     * - Product must exist and be in stock
     * - Quantity must be positive and not exceed available stock
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function add(Request $request, Product $product): RedirectResponse
    {
        // Validate quantity input
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.min' => 'Quantity must be at least 1.',
        ]);

        $quantity = $validated['quantity'];

        // Check stock availability
        if (!$product->isInStock() || $quantity > $product->stock) {
            return redirect()
                ->back()
                ->with('error', 'Sorry, this product is not available in the requested quantity.');
        }

        // Retrieve existing cart
        $cart = Session::get(self::CART_SESSION_KEY, []);

        // Check if product already exists in cart
        $existingKey = array_search($product->id, array_column($cart, 'product_id'));

        if ($existingKey !== false) {
            // Update quantity for existing item
            $newQuantity = $cart[$existingKey]['quantity'] + $quantity;

            // Validate against stock limit
            if ($newQuantity > $product->stock) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot add more than available stock.');
            }

            $cart[$existingKey]['quantity'] = $newQuantity;
        } else {
            // Add new item to cart
            $cart[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'added_at' => now(),
            ];
        }

        // Save updated cart to session
        Session::put(self::CART_SESSION_KEY, $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', "{$product->name} added to cart successfully!");
    }

    /**
     * Update the quantity of an item in the cart.
     *
     * @param Request $request
     * @param int $index The cart item index (0-based)
     * @return RedirectResponse
     */
    public function update(Request $request, int $index): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = Session::get(self::CART_SESSION_KEY, []);

        // Validate index bounds
        if (!isset($cart[$index])) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Cart item not found.');
        }

        $quantity = $validated['quantity'];

        // Remove item if quantity is zero or less
        if ($quantity <= 0) {
            array_splice($cart, $index, 1);
            Session::put(self::CART_SESSION_KEY, $cart);

            return redirect()
                ->route('cart.index')
                ->with('success', 'Item removed from cart.');
        }

        // Validate against stock
        $product = Product::find($cart[$index]['product_id']);
        if (!$product || $quantity > $product->stock) {
            return redirect()
                ->back()
                ->with('error', 'Requested quantity exceeds available stock.');
        }

        // Update quantity
        $cart[$index]['quantity'] = $quantity;
        Session::put(self::CART_SESSION_KEY, $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove a specific item from the cart.
     *
     * @param int $index The cart item index (0-based)
     * @return RedirectResponse
     */
    public function remove(int $index): RedirectResponse
    {
        $cart = Session::get(self::CART_SESSION_KEY, []);

        if (!isset($cart[$index])) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Item not found in cart.');
        }

        $productName = Product::find($cart[$index]['product_id'])?->name ?? 'Item';

        // Remove item at specified index
        array_splice($cart, $index, 1);
        Session::put(self::CART_SESSION_KEY, $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', "{$productName} removed from cart.");
    }

    /**
     * Clear all items from the shopping cart.
     *
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        Session::forget(self::CART_SESSION_KEY);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Shopping cart has been cleared.');
    }

    /**
     * Get the current cart item count for display in navigation.
     *
     * This method can be called from a view composer or controller.
     *
     * @return int
     */
    public static function getCartCount(): int
    {
        $cart = Session::get(self::CART_SESSION_KEY, []);
        return array_sum(array_column($cart, 'quantity'));
    }
}
