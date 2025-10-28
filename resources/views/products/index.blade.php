<x-app-layout>
    <x-slot name="title">Products - Elchapo Café</x-slot>

    <style>
        .products-container {
            min-height: calc(100vh - 80px);
            background: linear-gradient(135deg, #fef7ed 0%, #fffbeb 100%);
        }
        
        .product-card {
            background: linear-gradient(135deg, #ffffff 0%, #fefdfb 100%);
            border: 1px solid rgba(251, 191, 36, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(251, 191, 36, 0.05), transparent);
            transition: left 0.6s;
        }
        
        .product-card:hover::before {
            left: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(146, 64, 14, 0.15);
            border-color: rgba(251, 191, 36, 0.4);
        }
        
        .add-product-btn {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .add-product-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.3);
            background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
        }
        
        .order-btn {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
        }
        
        .action-link {
            transition: all 0.2s ease;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .edit-btn:hover {
            background: rgba(59, 130, 246, 0.1);
        }
        
        .delete-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }
        
        .price-tag {
            background: linear-gradient(135deg, #fef3c7 0%, #fef7ed 100%);
            border: 1px solid rgba(251, 191, 36, 0.3);
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
            
            .product-card {
                margin: 0 auto;
                max-width: 400px;
            }
        }
        
        @media (min-width: 641px) and (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1025px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>

    <div class="products-container py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="page-header flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 sm:mb-12 gap-4">
                <div>
                    <h1 class="page-title text-4xl sm:text-5xl font-bold bg-gradient-to-r from-amber-900 via-amber-700 to-amber-600 bg-clip-text text-transparent drop-shadow-sm">
                        Our Products
                    </h1>
                    <p class="text-amber-700 mt-2 text-lg sm:text-xl">
                        Manage your coffee shop offerings
                    </p>
                </div>
                <a href="{{ route('products.create') }}" 
                   class="add-product-btn text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl shadow-lg flex items-center justify-center space-x-2 text-lg font-semibold">
                    <span>+</span>
                    <span>Add New Product</span>
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="products-grid grid gap-6 sm:gap-8">
                    @foreach ($products as $product)
                        <div class="product-card rounded-2xl p-6 sm:p-8">
                            <!-- Product Header -->
                            <div class="mb-4 sm:mb-6">
                                <h3 class="text-xl sm:text-2xl font-bold text-amber-900 leading-tight">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 mt-2 sm:mt-3 text-sm sm:text-base leading-relaxed">
                                    {{ $product->description ?? 'No description available' }}
                                </p>
                            </div>

                            <!-- Product Footer -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
                                <div class="price-tag px-4 py-2 rounded-lg">
                                    <span class="text-lg sm:text-xl font-bold text-amber-900">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <!-- Order Button -->
                                    <a href="{{ route('products.order', $product) }}" 
                                       class="order-btn text-white px-4 py-2 rounded-lg text-center text-sm sm:text-base">
                                        🛒 Order
                                    </a>
                                    <div class="flex space-x-3 sm:space-x-4">
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="edit-btn action-link text-blue-600 hover:text-blue-800 text-sm sm:text-base">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    class="delete-btn action-link text-red-600 hover:text-red-800 text-sm sm:text-base">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">☕</div>
                    <h3 class="text-2xl font-bold text-amber-800 mb-2">No Products Yet</h3>
                    <p class="text-amber-600 mb-6">Get started by adding your first product to the menu.</p>
                    <a href="{{ route('products.create') }}" 
                       class="add-product-btn text-white px-8 py-4 rounded-xl shadow-lg inline-block">
                        + Add Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>