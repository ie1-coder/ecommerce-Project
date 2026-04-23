<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register web routes for your application. These routes receive the
| "web" middleware group by default, providing session state, CSRF
| protection, and more. Organized by access level and functionality.
|
*/

    // ============================================================================
    // PUBLIC ROUTES
    // Accessible without authentication - Core browsing experience
    // ============================================================================

    // Home page - Main landing page
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // Product browsing - Public catalog access
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');




    // ============================================================================
    // CATEGORY ROUTES - Public category browsing and filtering
    // ============================================================================

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');



    // ============================================================================
    // AUTHENTICATED ROUTES
    // Require user authentication - Protected user interactions
    // ============================================================================

    Route::middleware(['auth'])->group(function () {

    // -------------------------------------------------------------------------
    // Dashboard
    // User dashboard after successful login (Laravel Breeze default)
    // -------------------------------------------------------------------------

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // -------------------------------------------------------------------------
    // User Profile Management
    // Allow authenticated users to manage their account settings
    // -------------------------------------------------------------------------

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // -------------------------------------------------------------------------
    // Shopping Cart Operations
    // Full cart management: view, add, update, remove, clear
    // -------------------------------------------------------------------------

    Route::controller(CartController::class)
    ->prefix('cart')
    ->name('cart.')
    ->group
    (function ()
    {
        Route::get('/', 'index')->name('index');
        Route::post('/add/{product}', 'add')->name('add');
        Route::patch('/update/{item}', 'update')->name('update');
        Route::delete('/remove/{item}', 'remove')->name('remove');
        Route::delete('/clear', 'clear')->name('clear');
    });



    // -------------------------------------------------------------------------
    // Admin Product Management (CRUD)
    // Protected routes for product administration
    // NOTE: Consider adding role-based middleware (e.g., 'admin') here
    // -------------------------------------------------------------------------

    Route::controller(ProductController::class)->prefix('admin/products')->name('products.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::put('/{product}', 'update')->name('update');
        Route::delete('/{product}', 'destroy')->name('destroy');
    });

});

// ============================================================================
// AUTHENTICATION ROUTES
// Laravel Breeze/Fortify predefined authentication routes
// DO NOT MODIFY - Managed by Laravel authentication scaffolding
// ============================================================================

require __DIR__.'/auth.php';
