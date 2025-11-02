@extends('layouts.app')

@section('title', 'My Orders - Elchapo Café')

@section('styles')
<style>
    .orders-container {
        background: linear-gradient(135deg, #fef7ed 0%, #fffbeb 100%);
        min-height: 100vh;
    }
    
    .status-tabs {
        display: flex;
        background: white;
        border-radius: 12px;
        padding: 0.5rem;
        box-shadow: 0 4px 12px rgba(146, 64, 14, 0.1);
        margin-bottom: 2rem;
    }
    
    .status-tab {
        flex: 1;
        padding: 1rem;
        text-align: center;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        border: none;
        background: transparent;
    }
    
    .status-tab.active {
        background: #fed7aa;
        color: #92400e;
        box-shadow: 0 2px 8px rgba(146, 64, 14, 0.2);
    }
    
    .order-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(146, 64, 14, 0.1);
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .status-delivered {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #92400e;
    }
</style>
@endsection

@section('content')
<div class="orders-container py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-900 via-amber-700 to-amber-600 bg-clip-text text-transparent">
                My Orders
            </h1>
            <p class="text-amber-700 mt-2 text-lg">Track your coffee orders</p>
        </div>

        <!-- Status Tabs -->
        <div class="status-tabs">
            <button class="status-tab active" data-status="all">
                <i class="fas fa-list mr-2"></i>All Orders
            </button>
            <button class="status-tab" data-status="pending">
                <i class="fas fa-clock mr-2"></i>Pending
            </button>
            <button class="status-tab" data-status="processing">
                <i class="fas fa-shipping-fast mr-2"></i>On the Way
            </button>
            <button class="status-tab" data-status="delivered">
                <i class="fas fa-check-circle mr-2"></i>Delivered
            </button>
        </div>

        <!-- Orders List -->
        <div id="ordersContainer">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="order-card p-6" data-status="{{ $order->status }}">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <!-- Order Info -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-4 mb-4">
                                    <h3 class="text-xl font-bold text-gray-900">Order #{{ $order->id }}</h3>
                                    <span class="status-badge status-{{ $order->status }}">
                                        @if($order->status === 'pending')
                                            Pending
                                        @elseif($order->status === 'processing')
                                            On the Way
                                        @elseif($order->status === 'delivered')
                                            Delivered
                                        @else
                                            {{ ucfirst($order->status) }}
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-semibold">Date:</span>
                                        <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Items:</span>
                                        <span>{{ $order->orderItems->count() }} item(s)</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Total:</span>
                                        <span class="font-bold text-amber-900">Kshs {{ number_format($order->total_amount, 0) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Payment:</span>
                                        <span class="text-green-600">Paid</span>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="mt-4 space-y-2">
                                    @foreach($order->orderItems as $item)
                                        <div class="flex items-center space-x-3 text-sm">
                                            <div class="text-lg">☕</div>
                                            <span class="font-medium">{{ $item->product->name }}</span>
                                            <span class="text-gray-500">× {{ $item->quantity }}</span>
                                            <span class="text-amber-600">Kshs {{ number_format($item->price * $item->quantity, 0) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 md:mt-0 md:ml-6">
                                <a href="{{ route('orders.show', $order) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                <span>Order Placed</span>
                                <span>Processing</span>
                                <span>On the Way</span>
                                <span>Delivered</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full transition-all duration-500 
                                    @if($order->status === 'pending') w-1/4
                                    @elseif($order->status === 'processing') w-2/4
                                    @elseif($order->status === 'delivered') w-full
                                    @else w-1/4 @endif">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-2xl font-bold mb-2">No Orders Yet</h3>
                    <p class="text-amber-600 mb-6">Start your coffee journey with our delicious blends!</p>
                    <a href="{{ route('products.index') }}" class="add-product-btn inline-flex">
                        <i class="fas fa-coffee mr-2"></i>
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.status-tab');
        const orders = document.querySelectorAll('.order-card');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const status = this.dataset.status;
                
                // Filter orders
                orders.forEach(order => {
                    if (status === 'all' || order.dataset.status === status) {
                        order.style.display = 'block';
                    } else {
                        order.style.display = 'none';
                    }
                });
                
                // Show empty state if no orders match
                const visibleOrders = Array.from(orders).filter(order => 
                    order.style.display !== 'none'
                );
                
                // You could add an empty state message here if needed
            });
        });
    });
</script>
@endsection