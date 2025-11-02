@extends('layouts.app')

@section('title', 'Products - Elchapo Café')

@section('styles')
<style>
    .products-container {
        min-height: calc(100vh - 80px);
        background: linear-gradient(135deg, #fef7ed 0%, #fffbeb 100%);
    }
    
    .product-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(146, 64, 14, 0.1);
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 16px 0;
        justify-content: center;
    }
    
    .quantity-btn {
        width: 40px;
        height: 40px;
        border: 2px solid #d97706;
        background: white;
        color: #d97706;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .quantity-btn:hover:not(:disabled) {
        background: #d97706;
        color: white;
    }
    
    .quantity-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    
    .quantity-display {
        font-size: 20px;
        font-weight: bold;
        color: #1f2937;
        min-width: 40px;
        text-align: center;
    }
    
    .buy-now-btn {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .buy-now-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
    }
    
    .buy-now-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
    }
    
    .price-tag {
        font-size: 24px;
        font-weight: bold;
        color: #d97706;
        margin: 8px 0;
    }
    
    .stock-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .in-stock {
        background: #dcfce7;
        color: #166534;
    }
    
    .out-of-stock {
        background: #fecaca;
        color: #dc2626;
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .add-product-btn {
            width: 100%;
            max-width: 200px;
        }
    }
</style>
@endsection

@section('content')
<div class="products-container py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="page-header flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 sm:mb-12 gap-4">
            <div>
                <h1 class="page-title text-4xl sm:text-5xl font-bold bg-gradient-to-r from-amber-900 via-amber-700 to-amber-600 bg-clip-text text-transparent drop-shadow-sm">
                    Our Products
                </h1>
                <p class="text-amber-700 mt-2 text-lg sm:text-xl">
                    Select quantity and buy directly
                </p>
            </div>
            <!-- Removed "Add New Product" button -->
        </div>

        <!-- Products Grid -->
        @if($products && $products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($products as $product)
                    <div class="product-card p-6" data-product-id="{{ $product->id }}">
                        <!-- Product Image -->
                        <div class="text-center mb-4">
                            <div class="text-6xl mb-2">☕</div>
                        </div>

                        <!-- Product Info -->
                        <div class="text-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ $product->description ?? 'Premium coffee blend' }}</p>
                            
                            <!-- Stock Badge -->
                            @if($product->stock > 0)
                                <span class="stock-badge in-stock">In Stock ({{ $product->stock }})</span>
                            @else
                                <span class="stock-badge out-of-stock">Out of Stock</span>
                            @endif
                            
                            <!-- Price -->
                            <div class="price-tag">Kshs {{ number_format($product->price, 0) }}</div>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="quantity-controls">
                            <button type="button" 
                                    class="quantity-btn minus-btn" 
                                    data-product-id="{{ $product->id }}"
                                    disabled>-</button>
                            <span class="quantity-display" id="quantity-{{ $product->id }}">1</span>
                            <button type="button" 
                                    class="quantity-btn plus-btn" 
                                    data-product-id="{{ $product->id }}"
                                    {{ $product->stock <= 1 ? 'disabled' : '' }}>+</button>
                        </div>

                        <!-- Buy Now Button -->
                        <button type="button" 
                                class="buy-now-btn mt-4"
                                onclick="buyNow({{ $product->id }})"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                            {{ $product->stock == 0 ? 'Out of Stock' : 'Buy Now →' }}
                        </button>

                        <!-- Removed Admin Actions section -->
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="text-6xl mb-4">☕</div>
                <h3 class="text-2xl font-bold text-amber-800 mb-2">No Products Available</h3>
                <p class="text-amber-600 mb-6">Check back later for our coffee products.</p>
                <!-- Removed "Add Your First Product" button -->
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Quantity Controls
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Products page loaded');
        
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const isPlus = this.classList.contains('plus-btn');
                const quantityDisplay = document.getElementById(`quantity-${productId}`);
                
                if (!quantityDisplay) {
                    console.error('Quantity display not found for product:', productId);
                    return;
                }
                
                let quantity = parseInt(quantityDisplay.textContent);
                
                if (isPlus) {
                    quantity++;
                } else {
                    if (quantity > 1) {
                        quantity--;
                    }
                }
                
                quantityDisplay.textContent = quantity;
                
                // Update button states
                const minusBtn = document.querySelector(`.minus-btn[data-product-id="${productId}"]`);
                const plusBtn = document.querySelector(`.plus-btn[data-product-id="${productId}"]`);
                
                if (minusBtn) minusBtn.disabled = quantity <= 1;
                
                console.log(`Product ${productId} quantity: ${quantity}`);
            });
        });

        // Initialize button states
        document.querySelectorAll('.product-card').forEach(card => {
            const productId = card.dataset.productId;
            const minusBtn = document.querySelector(`.minus-btn[data-product-id="${productId}"]`);
            
            if (minusBtn) minusBtn.disabled = true;
        });
    });

    // Buy Now Function
    function buyNow(productId) {
        const quantityDisplay = document.getElementById(`quantity-${productId}`);
        if (!quantityDisplay) {
            alert('Error: Cannot determine quantity');
            return;
        }
        
        const quantity = parseInt(quantityDisplay.textContent);
        console.log(`Buying product ${productId}, quantity: ${quantity}`);
        
        // Redirect to shipping page
        window.location.href = `/products/${productId}/shipping/${quantity}`;
    }
</script>
@endsection