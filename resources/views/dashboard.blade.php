<x-app-layout>
    <x-slot name="title">Dashboard - Elchapo Café</x-slot>

    @php
        $avatar = Auth::user()->avatar
            ? asset('storage/' . Auth::user()->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=764ba2&color=fff';
    @endphp

    {{-- === NAVBAR === --}}
    <nav class="navbar fade-in">
        <div class="navbar-logo">☕ Elchapo Café</div>

        <div class="navbar-right">
            <a href="{{ route('dashboard') }}" 
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
               <i class="fas fa-tachometer-alt"></i>
               Dashboard
            </a>

            <a href="{{ route('products.index') }}" 
               class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
               <i class="fas fa-coffee"></i>
               Products
            </a>

            <a href="{{ route('orders.index') }}" 
               class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
               <i class="fas fa-shopping-bag"></i>
               Orders
            </a>

            <a href="{{ route('cart') }}" 
               class="nav-link {{ request()->routeIs('cart') ? 'active' : '' }}">
               <i class="fas fa-shopping-cart"></i>
               Cart 
               @if(session('cart') && count(session('cart')) > 0)
                   <span class="cart-badge">{{ count(session('cart')) }}</span>
               @endif
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>

            {{-- Avatar --}}
            <img src="{{ $avatar }}" alt="User Avatar" class="avatar-small" title="{{ Auth::user()->name }}">
        </div>
    </nav>

    {{-- === DASHBOARD BODY === --}}
    <div class="dashboard-bg fade-in">
        @if (session('success'))
            <div class="fade-in p-4 mb-6 text-green-800 bg-green-100 border border-green-300 rounded-xl text-center shadow-lg max-w-xl mx-auto">
                <span class="font-semibold">✅ {{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="fade-in p-4 mb-6 text-red-800 bg-red-100 border border-red-300 rounded-xl text-center shadow-lg max-w-xl mx-auto">
                <span class="font-semibold">❌ {{ session('error') }}</span>
            </div>
        @endif

        <h1 class="welcome-text">Welcome to Elchapo Café ☕, {{ Auth::user()->name }}!</h1>
        
        {{-- Stats Grid --}}
        <div class="stats-grid">
            <div class="dashboard-card" onclick="window.location='{{ route('products.index') }}'">
                <div class="text-4xl mb-2">📦</div>
                <h3 class="text-2xl font-bold mb-2">Total Products</h3>
                <p class="text-3xl font-bold">{{ $productsCount ?? '12' }}</p>
                <p class="text-sm opacity-75 mt-2">Click to view all products</p>
            </div>

            <div class="dashboard-card" onclick="window.location='{{ route('orders.index') }}'">
                <div class="text-4xl mb-2">🛒</div>
                <h3 class="text-2xl font-bold mb-2">Today's Orders</h3>
                <p class="text-3xl font-bold">{{ $ordersToday ?? '5' }}</p>
                <p class="text-sm opacity-75 mt-2">Click to view orders</p>
            </div>

            <div class="dashboard-card" onclick="window.location='{{ route('products.index') }}'">
                <div class="text-4xl mb-2">⭐</div>
                <h3 class="text-2xl font-bold mb-2">Customer Rating</h3>
                <p class="text-3xl font-bold">4.8/5</p>
                <p class="text-sm opacity-75 mt-2">Based on 150+ reviews</p>
            </div>

            <div class="dashboard-card" onclick="window.location='{{ route('orders.index') }}'">
                <div class="text-4xl mb-2">💰</div>
                <h3 class="text-2xl font-bold mb-2">Revenue</h3>
                <p class="text-3xl font-bold">Kshs 25,430</p>
                <p class="text-sm opacity-75 mt-2">This month</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="quick-actions">
            <a href="{{ route('products.index') }}" class="btn-primary">
                <i class="fas fa-coffee"></i>
                Browse Products
            </a>
            <a href="{{ route('products.create') }}" class="btn-secondary">
                <i class="fas fa-plus"></i>
                Add New Product
            </a>
            <a href="{{ route('cart') }}" class="btn-secondary">
                <i class="fas fa-shopping-cart"></i>
                View Cart
            </a>
            <a href="{{ route('orders.index') }}" class="btn-secondary">
                <i class="fas fa-list-alt"></i>
                My Orders
            </a>
        </div>

        {{-- Featured Products --}}
        <div class="dashboard-card mt-8 max-w-4xl w-full">
            <h3 class="text-2xl font-bold mb-6 text-center">🔥 Featured Products</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white/10 rounded-lg p-4 flex items-center justify-between hover:bg-white/15 transition cursor-pointer" onclick="window.location='{{ route('products.index') }}'">
                    <div class="flex items-center">
                        <div class="text-2xl mr-3">☕</div>
                        <div>
                            <h4 class="font-bold">Espresso Blend</h4>
                            <p class="text-sm opacity-75">Kshs 120</p>
                        </div>
                    </div>
                    <button class="btn-primary text-sm py-1 px-3">
                        <i class="fas fa-cart-plus"></i>
                        Add
                    </button>
                </div>
                
                <div class="bg-white/10 rounded-lg p-4 flex items-center justify-between hover:bg-white/15 transition cursor-pointer" onclick="window.location='{{ route('products.index') }}'">
                    <div class="flex items-center">
                        <div class="text-2xl mr-3">🍫</div>
                        <div>
                            <h4 class="font-bold">Mocha Delight</h4>
                            <p class="text-sm opacity-75">Kshs 170</p>
                        </div>
                    </div>
                    <button class="btn-primary text-sm py-1 px-3">
                        <i class="fas fa-cart-plus"></i>
                        Add
                    </button>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="dashboard-card mt-6 max-w-4xl w-full">
            <h3 class="text-2xl font-bold mb-4 text-center">📈 Recent Activity</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-white/10 rounded-lg hover:bg-white/15 transition cursor-pointer">
                    <div class="flex items-center">
                        <div class="text-green-400 mr-3">✅</div>
                        <span>New order #0012 received</span>
                    </div>
                    <span class="text-sm opacity-75">2 hours ago</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white/10 rounded-lg hover:bg-white/15 transition cursor-pointer">
                    <div class="flex items-center">
                        <div class="text-blue-400 mr-3">📦</div>
                        <span>Product "Espresso" stock updated</span>
                    </div>
                    <span class="text-sm opacity-75">5 hours ago</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white/10 rounded-lg hover:bg-white/15 transition cursor-pointer">
                    <div class="flex items-center">
                        <div class="text-yellow-400 mr-3">⭐</div>
                        <span>New customer review received</span>
                    </div>
                    <span class="text-sm opacity-75">1 day ago</span>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Add interactive features
            document.addEventListener('DOMContentLoaded', function() {
                // Add loading animation to cards
                const cards = document.querySelectorAll('.dashboard-card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });

                // Make all cards clickable
                cards.forEach(card => {
                    if (card.onclick) {
                        card.style.cursor = 'pointer';
                    }
                });

                // Update cart count in real-time
                function updateCartCount() {
                    const cart = {!! json_encode(session('cart', [])) !!};
                    const cartCount = Object.keys(cart).length;
                    const cartBadge = document.querySelector('.cart-badge');
                    const cartLink = document.querySelector('.nav-link[href*="cart"]');
                    
                    if (cartCount > 0) {
                        if (cartBadge) {
                            cartBadge.textContent = cartCount;
                        } else {
                            const badge = document.createElement('span');
                            badge.className = 'cart-badge';
                            badge.textContent = cartCount;
                            cartLink.appendChild(badge);
                        }
                        cartLink.classList.add('active');
                    } else if (cartBadge) {
                        cartBadge.remove();
                    }
                }

                // Initial update
                updateCartCount();

                // Add ripple effect to buttons
                function createRipple(event) {
                    const button = event.currentTarget;
                    const circle = document.createElement("span");
                    const diameter = Math.max(button.clientWidth, button.clientHeight);
                    const radius = diameter / 2;

                    circle.style.width = circle.style.height = `${diameter}px`;
                    circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
                    circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
                    circle.classList.add("ripple");

                    const ripple = button.getElementsByClassName("ripple")[0];
                    if (ripple) {
                        ripple.remove();
                    }

                    button.appendChild(circle);
                }

                // Add ripple to all buttons
                const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .action-btn, .nav-link');
                buttons.forEach(button => {
                    button.addEventListener('click', createRipple);
                });
            });

            // Add ripple effect styles
            const style = document.createElement('style');
            style.textContent = `
                .ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple-animation 0.6s linear;
                }

                @keyframes ripple-animation {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }

                .btn-primary, .btn-secondary, .action-btn, .nav-link {
                    position: relative;
                    overflow: hidden;
                }
            `;
            document.head.appendChild(style);
        </script>
    </x-slot>
</x-app-layout>