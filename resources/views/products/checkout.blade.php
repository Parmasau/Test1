@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Shipping Information</div>
                <div class="card-body">
                    <form action="{{ route('process.order') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address *</label>
                            <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Billing Address (if different)</label>
                            <textarea name="billing_address" id="billing_address" class="form-control @error('billing_address') is-invalid @enderror" rows="3">{{ old('billing_address') }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="same_as_shipping">
                            <label class="form-check-label" for="same_as_shipping">
                                Billing address same as shipping
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-shopping-bag"></i> Place Order - ${{ number_format($total, 2) }}
                        </button>
                        
                        <a href="{{ route('cart') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Order Summary</div>
                <div class="card-body">
                    @foreach($cart as $id => $item)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-1">{{ $item['name'] }}</h6>
                            <small class="text-muted">Qty: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}</small>
                        </div>
                        <span class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Order Items</div>
                <div class="card-body">
                    @foreach($cart as $id => $item)
                    <div class="d-flex align-items-center mb-2">
                        @if($item['image'])
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center me-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $item['name'] }}</div>
                            <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                        </div>
                        <div class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
    const billingAddressTextarea = document.getElementById('billing_address');
    const shippingAddressTextarea = document.getElementById('shipping_address');

    sameAsShippingCheckbox.addEventListener('change', function() {
        if (this.checked) {
            billingAddressTextarea.value = shippingAddressTextarea.value;
            billingAddressTextarea.disabled = true;
        } else {
            billingAddressTextarea.disabled = false;
            billingAddressTextarea.value = '';
        }
    });

    // Auto-fill billing address if shipping address changes and checkbox is checked
    shippingAddressTextarea.addEventListener('input', function() {
        if (sameAsShippingCheckbox.checked) {
            billingAddressTextarea.value = this.value;
        }
    });
});
</script>
@endpush