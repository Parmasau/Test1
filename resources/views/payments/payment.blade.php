@extends('layouts.app')

@section('title', 'Payment - Order #' . $order->id . ' - Elchapo Café')

@section('styles')
<style>
    .payment-container {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        min-height: 100vh;
    }
    
    .payment-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(5, 150, 105, 0.1);
        border: 1px solid #d1fae5;
    }
    
    .btn-pay {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        width: 100%;
    }
    
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
    }
    
    .payment-method {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .payment-method:hover {
        border-color: #10b981;
        background: #f0fdf4;
    }
    
    .payment-method.selected {
        border-color: #10b981;
        background: #f0fdf4;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
    }
</style>
@endsection

@section('content')
<div class="payment-container py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="text-4xl mb-4">💳</div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-green-900 via-green-700 to-green-600 bg-clip-text text-transparent">
                Complete Payment
            </h1>
            <p class="text-green-700 mt-2 text-lg">Order #{{ $order->id }}</p>
        </div>

        <div class="payment-card p-6 sm:p-8">
            <!-- Order Summary -->
            <div class="bg-green-50 rounded-xl p-6 mb-6 border border-green-200">
                <h3 class="text-xl font-bold text-green-900 mb-4">Order Details</h3>
                <div class="space-y-2">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-semibold text-green-800">{{ $item->product->name }}</span>
                            <span class="text-green-600 text-sm">× {{ $item->quantity }}</span>
                        </div>
                        <span class="font-bold text-green-900">Kshs {{ number_format($item->price * $item->quantity, 0) }}</span>
                    </div>
                    @endforeach
                    <div class="border-t border-green-200 pt-2 mt-2">
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-green-900">Total Amount:</span>
                            <span class="text-green-900">Kshs {{ number_format($order->total_amount, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Select Payment Method</h3>
                <div class="space-y-4" id="paymentMethods">
                    <!-- M-Pesa -->
                    <div class="payment-method selected" data-method="mpesa">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-green-100 p-3 rounded-lg">
                                    <i class="fas fa-mobile-alt text-green-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">M-Pesa</h4>
                                    <p class="text-gray-600 text-sm">Pay via M-Pesa mobile money</p>
                                </div>
                            </div>
                            <div class="text-green-500">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                        
                        <!-- M-Pesa Details -->
                        <div class="mt-4 p-4 bg-green-50 rounded-lg" id="mpesaDetails">
                            <p class="text-green-800 text-sm mb-3">
                                You will receive an M-Pesa prompt on your phone to complete the payment.
                            </p>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-green-700 mb-1">Phone Number</label>
                                    <input type="text" 
                                           class="w-full border border-green-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="+254 XXX XXX XXX"
                                           value="{{ Auth::user()->phone ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Payment -->
                    <div class="payment-method" data-method="card">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 p-3 rounded-lg">
                                    <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Credit/Debit Card</h4>
                                    <p class="text-gray-600 text-sm">Pay with your card</p>
                                </div>
                            </div>
                            <div class="text-gray-400">
                                <i class="fas fa-circle text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Button -->
            <form action="{{ route('orders.process-payment', $order) }}" method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="payment_method" value="mpesa" id="paymentMethod">
                
                <button type="submit" class="btn-pay">
                    <i class="fas fa-lock mr-2"></i>
                    Pay Kshs {{ number_format($order->total_amount, 0) }}
                </button>
            </form>

            <!-- Security Notice -->
            <div class="text-center mt-6">
                <p class="text-gray-500 text-sm flex items-center justify-center space-x-2">
                    <i class="fas fa-shield-alt text-green-500"></i>
                    <span>Your payment is secure and encrypted</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentMethods = document.querySelectorAll('.payment-method');
        const paymentMethodInput = document.getElementById('paymentMethod');
        
        paymentMethods.forEach(method => {
            method.addEventListener('click', function() {
                // Remove selected class from all methods
                paymentMethods.forEach(m => {
                    m.classList.remove('selected');
                    m.querySelector('.fa-check-circle').classList.replace('fa-check-circle', 'fa-circle');
                    m.querySelector('.fa-check-circle')?.classList.replace('text-green-500', 'text-gray-400');
                });
                
                // Add selected class to clicked method
                this.classList.add('selected');
                const icon = this.querySelector('.fa-circle');
                icon.classList.replace('fa-circle', 'fa-check-circle');
                icon.classList.replace('text-gray-400', 'text-green-500');
                
                // Update hidden input
                const selectedMethod = this.dataset.method;
                paymentMethodInput.value = selectedMethod;
            });
        });

        // Form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const button = this.querySelector('button');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing Payment...';
            button.disabled = true;
            
            // Simulate payment processing
            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    });
</script>
@endsection