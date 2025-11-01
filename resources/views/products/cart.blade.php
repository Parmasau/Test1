@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Shopping Cart</h1>
    
    @if(empty($cart))
        <div class="alert alert-info text-center">
            <h4>Your cart is empty!</h4>
            <p>Start shopping to add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                @foreach($cart as $id => $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid" alt="{{ $item['name'] }}">
                                    @else
                                        <i class="fas fa-box text-muted"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-1">{{ $item['name'] }}</h5>
                                <p class="text-muted mb-0">${{ number_format($item['price'], 2) }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">Quantity: {{ $item['quantity'] }}</p>
                            </div>
                            <div class="col-md-2">
                                <p class="mb-0 fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                            <div class="col-md-1">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span>Free</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>${{ number_format($total, 2) }}</strong>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-credit-card"></i> Proceed to Checkout
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection