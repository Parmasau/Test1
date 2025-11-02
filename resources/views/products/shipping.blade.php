@extends('layouts.app')

@section('title', 'Order Confirmation - ' . $product->name . ' - Elchapo Café')

@section('styles')
<style>
    .shipping-container {
        background: linear-gradient(135deg, #fef7ed 0%, #fffbeb 100%);
        min-height: 100vh;
    }
    
    .confirmation-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(146, 64, 14, 0.1);
        border: 1px solid #e5e7eb;
    }
    
    .product-summary {
        background: #fef7ed;
        border-radius: 16px;
        border: 2px solid #fed7aa;
    }
    
    .btn-confirm {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        width: 100%;
    }
    
    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
    }
    
    .btn-cancel {
        background: #6b7280;
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        width: 100%;
    }
    
    .btn-cancel:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    .login-prompt {
        background: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
</style>
@endsection

@section('content')
<div class="shipping-container py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-900 via-amber-700 to-amber-600 bg-clip-text text-transparent">
                Order Confirmation
            </h1>
            <p class="text-amber-700 mt-2 text-lg">Review your order before proceeding to payment</p>
        </div>

        <!-- Check if user is authenticated -->
        @guest
            <div class="login-prompt">
                <div class="text-4xl mb-4">🔒</div>
                <h3 class="text-xl font-bold text-amber-900 mb-2">Authentication Required</h3>
                <p class="text-amber-700 mb-4">Please log in to complete your purchase.</p>
                <div class="flex space-x-4 justify-center">
                    <a href="{{ route('login') }}" class="btn-confirm">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-cancel">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register
                    </a>
                </div>
            </div>
        @endguest

        @auth
        <div class="confirmation-card p-6 sm:p-8">
            <!-- Product Summary -->
            <div class="product-summary p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <div class="text-5xl">☕</div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-amber-900">{{ $product->name }}</h3>
                        <p class="text-amber-700">{{ $product->description ?? 'Premium coffee blend' }}</p>
                        <div class="mt-3 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-amber-600">Quantity:</span>
                                <span class="font-semibold text-amber-900">{{ $quantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-amber-600">Unit Price:</span>
                                <span class="font-semibold text-amber-900">Kshs {{ number_format($product->price, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-lg border-t border-amber-200 pt-2">
                                <span class="text-amber-800 font-bold">Total:</span>
                                <span class="font-bold text-amber-900">Kshs {{ number_format($product->price * $quantity, 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            <form action="{{ route('products.purchase', $product) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="{{ $quantity }}">

                <!-- Shipping Information -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Shipping Information</h3>
                    
                    <div class="mb-4">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Shipping Address *
                        </label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                  placeholder="Enter your complete shipping address" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number *
                            </label>
                            <input type="text" name="phone" id="phone" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                   placeholder="+254 XXX XXX XXX" 
                                   value="{{ old('phone') }}" required>
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                City *
                            </label>
                            <input type="text" name="city" id="city" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                   placeholder="Enter your city" 
                                   value="{{ old('city') }}" required>
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Method</h3>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="mpesa" class="text-amber-500 focus:ring-amber-500" checked>
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-mobile-alt text-green-500 text-xl"></i>
                                <span class="font-medium">M-Pesa Mobile Money</span>
                            </span>
                        </label>
                        
                        <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="card" class="text-amber-500 focus:ring-amber-500">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-credit-card text-blue-500 text-xl"></i>
                                <span class="font-medium">Credit/Debit Card</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Final Summary -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Order Summary</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Product:</span>
                            <span>{{ $product->name }} × {{ $quantity }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>Kshs {{ number_format($product->price * $quantity, 0) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping:</span>
                            <span>Kshs 100</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-gray-300 pt-2">
                            <span>Total Amount:</span>
                            <span>Kshs {{ number_format(($product->price * $quantity) + 100, 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('products.index') }}" class="btn-cancel text-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancel Order
                    </a>
                    <button type="submit" class="btn-confirm">
                        <i class="fas fa-lock mr-2"></i>
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
        @endauth
    </div>
</div>
@endsection