<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Home route - show welcome page instead of redirect
Route::get('/', function () {
    return view('welcome');
});

// Dashboard - accessible directly
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Product Routes - all accessible directly
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Add the missing order route
Route::get('/products/{product}/order', [ProductController::class, 'order'])->name('products.order');

// Order Routes - accessible directly
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Cart Routes
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [ProductController::class, 'processOrder'])->name('process.order');

// User orders
Route::get('/my-orders', [ProductController::class, 'myOrders'])->name('orders.my');

require __DIR__.'/auth.php';