@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-box fa-5x text-muted"></i>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $product->name }}</h1>
                    <p class="h2 text-primary">${{ number_format($product->price, 2) }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} fs-6">
                            {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    
                    <p class="card-text">{{ $product->description }}</p>
                    
                    <div class="d-flex gap-2 mt-4">
                        @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-times"></i> Out of Stock
                        </button>
                        @endif
                        
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection