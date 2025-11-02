<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Public routes (no authentication required)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Protected routes (authentication required)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $data = [
            'productsCount' => \App\Models\Product::count(),
            'ordersToday' => \App\Models\Order::whereDate('created_at', today())->count(),
        ];
        
        return view('dashboard', $data);
    })->name('dashboard');

    // Product management routes (if needed later)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Purchase routes
    Route::get('/products/{product}/shipping/{quantity?}', [ProductController::class, 'showShipping'])
        ->name('products.shipping');
    Route::post('/products/{product}/purchase', [ProductController::class, 'directPurchase'])
        ->name('products.purchase');

    // Cart routes
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [ProductController::class, 'processOrder'])->name('process.order');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Payment routes
    Route::get('/orders/{order}/payment', [PaymentController::class, 'showPayment'])->name('orders.payment');
    Route::post('/orders/{order}/process-payment', [PaymentController::class, 'processPayment'])->name('orders.process-payment');

    // User orders
    Route::get('/my-orders', [ProductController::class, 'myOrders'])->name('orders.my');
});

require __DIR__.'/auth.php';