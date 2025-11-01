<x-app-layout>
    <x-slot name="title">Order {{ $product->name }} - Elchapo Café</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-amber-900">Order {{ $product->name }}</h1>
                    <p class="text-amber-600 mt-2">Complete your order details</p>
                </div>

                <!-- Product Info -->
                <div class="bg-amber-50 rounded-xl p-6 mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-amber-900">{{ $product->name }}</h3>
                            <p class="text-amber-700">{{ $product->description }}</p>
                            <div class="mt-2">
                                <span class="text-2xl font-bold text-amber-900">${{ number_format($product->price, 2) }}</span>
                                <span class="ml-2 text-sm text-amber-600">In Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Form -->
                <form action="{{ route('process.order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Quantity -->
                    <div class="mb-6">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <select name="quantity" id="quantity" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @for($i = 1; $i <= min($product->stock, 10); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                  placeholder="Enter your complete shipping address" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Billing Address -->
                    <div class="mb-6">
                        <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Billing Address 
                            <span class="text-gray-500 text-sm">(optional)</span>
                        </label>
                        <textarea name="billing_address" id="billing_address" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                  placeholder="Enter billing address if different from shipping">{{ old('billing_address') }}</textarea>
                        @error('billing_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-2">Order Summary</h4>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Product:</span>
                            <span>{{ $product->name }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                            <span>Quantity:</span>
                            <span id="summary-quantity">1</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold text-amber-900 mt-2">
                            <span>Total:</span>
                            <span id="summary-total">${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" 
                           class="flex-1 bg-gray-500 text-white text-center py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="flex-1 bg-amber-600 text-white py-3 px-6 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Update order summary when quantity changes
        document.getElementById('quantity').addEventListener('change', function() {
            const quantity = parseInt(this.value);
            const price = {{ $product->price }};
            const total = quantity * price;
            
            document.getElementById('summary-quantity').textContent = quantity;
            document.getElementById('summary-total').textContent = '$' + total.toFixed(2);
        });
    </script>
</x-app-layout>