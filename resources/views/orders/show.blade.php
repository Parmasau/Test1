@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Order Items</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                    <div class="row align-items-center mb-4 pb-3 border-bottom">
                        <div class="col-md-2">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="img-fluid rounded">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="height: 80px;">
                                <i class="fas fa-box fa-2x text-muted"></i>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <p class="text-muted mb-0 small">{{ $item->product->description }}</p>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="fw-bold">Qty: {{ $item->quantity }}</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <div>
                                <small class="text-muted">${{ number_format($item->price, 2) }} each</small>
                            </div>
                            <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-12 text-end">
                            <h4>Total: ${{ number_format($order->total_amount, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Order Status:</strong><br>
                        <span class="badge bg-{{ 
                            $order->status == 'completed' ? 'success' : 
                            ($order->status == 'processing' ? 'primary' : 
                            ($order->status == 'shipped' ? 'info' : 'warning')) 
                        }} text-capitalize fs-6 mt-1">
                            {{ $order->status }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Order Date:</strong><br>
                        <i class="fas fa-calendar text-muted"></i>
                        {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Shipping Address:</strong><br>
                        <i class="fas fa-map-marker-alt text-muted"></i>
                        {{ $order->shipping_address }}
                    </div>
                    
                    @if($order->billing_address)
                    <div class="mb-3">
                        <strong>Billing Address:</strong><br>
                        <i class="fas fa-receipt text-muted"></i>
                        {{ $order->billing_address }}
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted">Thank you for your order!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection