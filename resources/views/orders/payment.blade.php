<x-app-layout>
    <x-slot name="title">Payment - Order #{{ $order->id }}</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-amber-900">Complete Payment</h1>
                    <p class="text-amber-600 mt-2">Order #{{ $order->id }}</p>
                </div>

                <!-- Order Summary -->
                <div class="bg-amber-50 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-amber-900 mb-4">Order Details</h3>
                    
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-4">
                            <div class="text-3xl">☕</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-900">
                                Kshs {{ number_format($item->price * $item->quantity, 0) }}
                            </p>
                        </div>
                    </div>
                    @endforeach

                    <div class="border-t border-amber-200 pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-amber-900">Total Amount:</span>
                            <span class="text-2xl font-bold text-amber-900">
                                Kshs {{ number_format($order->total_amount, 0) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="{{ route('orders.payment', $order) }}" method="POST">
                    @csrf
                    
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>
                        
                        <!-- M-Pesa Option -->
                        <div class="flex items-center mb-4 p-4 border border-amber-300 rounded-lg bg-amber-25">
                            <input type="radio" id="mpesa" name="payment_method" value="mpesa" class="mr-3" checked>
                            <label for="mpesa" class="flex items-center">
                                <span class="text-2xl mr-2">📱</span>
                                <div>
                                    <div class="font-semibold text-gray-900">M-Pesa</div>
                                    <div class="text-sm text-gray-600">Pay via M-Pesa mobile money</div>
                                </div>
                            </label>
                        </div>

                        <!-- Card Option -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <input type="radio" id="card" name="payment_method" value="card" class="mr-3">
                            <label for="card" class="flex items-center">
                                <span class="text-2xl mr-2">💳</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-600">Pay with your card</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Shipping Information</h3>
                        <p class="text-gray-700">{{ $order->shipping_address }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-4">
                        <a href="{{ route('orders.show', $order) }}" 
                           class="flex-1 bg-gray-500 text-white text-center py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors">
                            ← Back to Order
                        </a>
                        <button type="submit" 
                                class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors font-semibold text-lg">
                            ✅ Complete Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>