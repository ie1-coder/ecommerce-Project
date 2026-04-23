<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;


/**
 * Class CategoryController
 *
 * Handles category browsing and product filtering operations.
 * Supports both ID and slug-based routing for SEO optimization.
 *
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its products.
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        // Eager load products with pagination
        $products = $category->products()
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Get subcategories if your model supports it
        $subcategories = $category->children ?? collect();

        return view('categories.show', compact('category', 'products', 'subcategories'));
    }
}
