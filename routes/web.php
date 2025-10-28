<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

// This is the ONLY dashboard route - it includes products
Route::get('/dashboard', function () {
    $products = App\Models\Product::all();
    return view('dashboard', compact('products'));
})->name('dashboard');

Route::resource('products', ProductController::class);
Route::get('/products/{product}/order', [ProductController::class, 'order'])->name('products.order');
Route::resource('orders', OrderController::class);

require __DIR__.'/auth.php';