<x-app-layout>
    <x-slot name="title">Order {{ $product->name }} - Elchapo Café</x-slot>

    <style>
        .order-container {
            min-height: calc(100vh - 80px);
            background: linear-gradient(135deg, #fef7ed 0%, #fffbeb 100%);
        }
        
        .product-card {
            background: linear-gradient(135deg, #ffffff 0%, #fefdfb 100%);
            border: 1px solid rgba(251, 191, 36, 0.2);
            box-shadow: 0 10px 30px rgba(146, 64, 14, 0.1);
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .quantity-btn {
            width: 50px;
            height: 50px;
            border: 2px solid #d97706;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #d97706;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .quantity-btn:hover {
            background: #d97706;
            color: white;
            transform: scale(1.1);
        }
        
        .quantity-display {
            font-size: 2rem;
            font-weight: bold;
            color: #92400e;
            min-width: 60px;
            text-align: center;
        }
        
        .order-btn {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 1rem 2rem;
            font-size: 1.25rem;
        }
        
        .order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(217, 119, 6, 0.4);
        }
        
        .price-display {
            background: linear-gradient(135deg, #fef3c7 0%, #fef7ed 100%);
            border: 2px solid rgba(251, 191, 36, 0.3);
            padding: 1rem 2rem;
            border-radius: 15px;
        }
        
        .total-price {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #92400e 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .quantity-pulse {
            animation: pulse 0.3s ease;
        }
    </style>

    <div class="order-container py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-8 sm:mb-12">
                <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-amber-900 via-amber-700 to-amber-600 bg-clip-text text-transparent drop-shadow-sm mb-4">
                    Order Product
                </h1>
            </div>

            <!-- Product Card -->
            <div class="product-card rounded-2xl p-6 sm:p-8">
                <!-- Product Information -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-amber-900 mb-4">
                        {{ $product->name }}
                    </h2>
                    <p class="text-gray-600 text-lg sm:text-xl leading-relaxed mb-6">
                        {{ $product->description ?? 'No description available' }}
                    </p>
                    
                    <div class="price-display inline-block">
                        <span class="text-2xl sm:text-3xl font-bold text-amber-900">
                            ${{ number_format($product->price, 2) }} each
                        </span>
                    </div>
                </div>

                <!-- Quantity Controls -->
                <div class="quantity-controls">
                    <button onclick="decreaseQuantity()" class="quantity-btn" id="decreaseBtn">-</button>
                    <div class="quantity-display" id="quantityDisplay">1</div>
                    <button onclick="increaseQuantity()" class="quantity-btn" id="increaseBtn">+</button>
                </div>

                <!-- Total Price -->
                <div class="text-center mb-8">
                    <p class="text-amber-700 text-lg mb-2">Total Amount:</p>
                    <div class="total-price" id="totalPrice">${{ number_format($product->price, 2) }}</div>
                </div>

                <!-- Order Button -->
                <form action="{{ route('orders.store') }}" method="POST" class="text-center">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <input type="hidden" name="total_price" id="totalPriceInput" value="{{ $product->price }}">
                    
                    <button type="submit" class="order-btn text-white rounded-xl shadow-lg mx-auto flex items-center justify-center space-x-2">
                        <span>🛒</span>
                        <span>Place Order</span>
                    </button>
                </form>

                <!-- Back Link -->
                <div class="text-center mt-6">
                    <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-800 transition font-medium">
                        ← Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let quantity = 1;
        const price = {{ $product->price }};
        
        function updateDisplay() {
            const quantityDisplay = document.getElementById('quantityDisplay');
            const totalPrice = document.getElementById('totalPrice');
            const quantityInput = document.getElementById('quantityInput');
            const totalPriceInput = document.getElementById('totalPriceInput');
            const decreaseBtn = document.getElementById('decreaseBtn');
            
            quantityDisplay.textContent = quantity;
            quantityDisplay.classList.add('quantity-pulse');
            setTimeout(() => quantityDisplay.classList.remove('quantity-pulse'), 300);
            
            const total = quantity * price;
            totalPrice.textContent = `$${total.toFixed(2)}`;
            
            quantityInput.value = quantity;
            totalPriceInput.value = total;
            
            decreaseBtn.disabled = quantity === 1;
            decreaseBtn.style.opacity = quantity === 1 ? '0.5' : '1';
        }
        
        function increaseQuantity() {
            quantity++;
            updateDisplay();
        }
        
        function decreaseQuantity() {
            if (quantity > 1) {
                quantity--;
                updateDisplay();
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateDisplay();
        });
    </script>
</x-app-layout>