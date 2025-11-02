@extends('layouts.app')

@section('title', 'Dashboard - Elchapo Café')

@section('styles')
<style>
    .dashboard-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 1rem;
    }
    
    .welcome-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .welcome-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #ffd966 0%, #ffcc33 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .action-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .action-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: white;
    }
    
    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .action-content {
        flex: 1;
    }
    
    .action-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .action-description {
        font-size: 0.875rem;
        opacity: 0.8;
    }
    
    .recent-activity {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        color: white;
    }
    
    .activity-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.05);
    }
    
    .activity-item:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-text {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.875rem;
        opacity: 0.7;
    }
    
    /* Color variants for icons */
    .icon-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .icon-success { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
    .icon-warning { background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); }
    .icon-info { background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); }
    .icon-purple { background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%); }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .dashboard-bg {
            padding: 1rem 0.5rem;
        }
        
        .welcome-card {
            padding: 2rem 1rem;
        }
        
        .welcome-icon {
            font-size: 3rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .stat-number {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-bg">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-icon">☕</div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Elchapo Café, {{ Auth::user()->name }}!</h1>
            <p class="text-xl opacity-90">Start your day with the perfect brew. What would you like to do today?</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card" onclick="window.location='{{ route('products.index') }}'">
                <div class="stat-icon">📦</div>
                <div class="stat-number">{{ $productsCount ?? '12' }}</div>
                <div class="stat-label">Total Products</div>
            </div>
            
            <div class="stat-card" onclick="window.location='{{ route('orders.index') }}'">
                <div class="stat-icon">🛒</div>
                <div class="stat-number">{{ $ordersToday ?? '5' }}</div>
                <div class="stat-label">Today's Orders</div>
            </div>
            
            <div class="stat-card" onclick="window.location='{{ route('products.index') }}'">
                <div class="stat-icon">⭐</div>
                <div class="stat-number">4.8</div>
                <div class="stat-label">Customer Rating</div>
            </div>
            
            <div class="stat-card" onclick="window.location='{{ route('orders.index') }}'">
                <div class="stat-icon">💰</div>
                <div class="stat-number">Kshs {{ number_format(25430, 0) }}</div>
                <div class="stat-label">Monthly Revenue</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('products.index') }}" class="action-card">
                <div class="action-icon icon-primary">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="action-content">
                    <div class="action-title">Browse Products</div>
                    <div class="action-description">Explore our coffee collection</div>
                </div>
                <i class="fas fa-chevron-right opacity-60"></i>
            </a>
            
            <a href="{{ route('cart') }}" class="action-card">
                <div class="action-icon icon-success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="action-content">
                    <div class="action-title">View Cart</div>
                    <div class="action-description">Check your selected items</div>
                </div>
                <i class="fas fa-chevron-right opacity-60"></i>
            </a>
            
            <a href="{{ route('orders.index') }}" class="action-card">
                <div class="action-icon icon-warning">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="action-content">
                    <div class="action-title">My Orders</div>
                    <div class="action-description">Track your purchases</div>
                </div>
                <i class="fas fa-chevron-right opacity-60"></i>
            </a>
            
            <a href="{{ route('products.index') }}" class="action-card">
                <div class="action-icon icon-info">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="action-content">
                    <div class="action-title">Quick Order</div>
                    <div class="action-description">Fast checkout process</div>
                </div>
                <i class="fas fa-chevron-right opacity-60"></i>
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="activity-title">
                <i class="fas fa-history"></i>
                Recent Activity
            </h2>
            
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">New order #0012 received</div>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon icon-primary">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Order #0010 is on the way</div>
                        <div class="activity-time">5 hours ago</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon icon-warning">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">New customer review received</div>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon icon-info">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Product "Espresso" stock updated</div>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon icon-purple">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Special offer: 20% off first order</div>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to stat cards on load
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in');
        });

        // Add hover effects to activity items
        const activityItems = document.querySelectorAll('.activity-item');
        activityItems.forEach(item => {
            item.addEventListener('click', function() {
                // Add click functionality if needed
                console.log('Activity item clicked');
            });
        });

        // Update real-time data (simulated)
        function updateRealTimeData() {
            // In a real app, you would fetch this from an API
            const ordersElement = document.querySelector('.stat-number:nth-child(2)');
            if (ordersElement) {
                const currentOrders = parseInt(ordersElement.textContent);
                // Simulate occasional order updates
                if (Math.random() > 0.7) {
                    ordersElement.textContent = currentOrders + 1;
                    // Add a subtle animation
                    ordersElement.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        ordersElement.style.transform = 'scale(1)';
                    }, 300);
                }
            }
        }

        // Update every 30 seconds
        setInterval(updateRealTimeData, 30000);
    });
</script>
@endsection