@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Orders</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            <h4><i class="fas fa-box-open"></i> No orders found</h4>
            <p class="mb-3">
                @if(session('error'))
                    There seems to be a technical issue with the orders system.
                @else
                    You haven't placed any orders yet.
                @endif
            </p>
            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary me-2">
                    <i class="fas fa-shopping-bag"></i> Start Shopping
                </a>
                <a href="{{ route('cart') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-shopping-cart"></i> View Cart
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Order #{{ $order->id }}</h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> 
                                {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ 
                                $order->status == 'completed' ? 'success' : 
                                ($order->status == 'processing' ? 'primary' : 
                                ($order->status == 'shipped' ? 'info' : 'warning')) 
                            }} text-capitalize fs-6">
                                {{ $order->status }}
                            </span>
                            <p class="mb-0 fw-bold mt-1">${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($order->orderItems as $item)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-1">
                                @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 50px;">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-box text-muted"></i>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-5">
                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="text-muted">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="text-muted">${{ number_format($item->price, 2) }} each</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="mt-3 pt-3 border-top">
                            <div class="row">
                                <div class="col-md-8">
                                    <small class="text-muted">
                                        <strong>Shipping Address:</strong><br>
                                        {{ $order->shipping_address }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection