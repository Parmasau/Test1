<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* === ANIMATION === */
        .fade-in {
            animation: fadeInSlide 0.8s ease-out forwards;
        }
        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* === NAVBAR === */
        .navbar {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(118, 75, 162, 0.95);
            color: white;
            padding: 0.8rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .navbar-logo {
            font-size: 1.4rem;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover {
            color: #ffd966;
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 217, 102, 0.3);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
            border-color: #ffd966;
            box-shadow: 0 4px 12px rgba(255, 217, 102, 0.3);
        }

        .avatar-small {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            transition: transform 0.2s ease-in-out;
        }

        .avatar-small:hover {
            transform: scale(1.05);
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.2);
            color: #fecaca;
            border: 2px solid rgba(239, 68, 68, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            color: white;
            border-color: #ef4444;
            transform: translateY(-2px);
        }

        .cart-badge {
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            margin-left: 0.5rem;
        }

        /* Main content area */
        .main-content {
            min-height: calc(100vh - 80px);
            padding-top: 80px; /* Account for fixed navbar */
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.6rem 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-right {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-link {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }

            .avatar-small {
                width: 40px;
                height: 40px;
            }

            .main-content {
                padding-top: 120px; /* More padding for mobile stacked navbar */
            }
        }

        @media (max-width: 480px) {
            .navbar-logo {
                font-size: 1.1rem;
            }
            
            .navbar-right {
                gap: 0.8rem;
            }
            
            .nav-link {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
            
            .main-content {
                padding-top: 140px; /* Even more padding for very small screens */
            }
        }
    </style>

    <!-- Page-specific styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    @auth
        <nav class="navbar fade-in">
            <div class="navbar-logo">☕ Elchapo Café</div>

            <div class="navbar-right">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                   <i class="fas fa-tachometer-alt"></i>
                   <span class="hidden sm:inline">Dashboard</span>
                </a>

                <a href="{{ route('products.index') }}" 
                   class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                   <i class="fas fa-coffee"></i>
                   <span class="hidden sm:inline">Products</span>
                </a>

                <a href="{{ route('orders.index') }}" 
                   class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                   <i class="fas fa-shopping-bag"></i>
                   <span class="hidden sm:inline">Orders</span>
                </a>

                {{-- Cart Link - Only show if cart route exists --}}
                @if(Route::has('cart'))
                <a href="{{ route('cart') }}" 
                   class="nav-link {{ request()->routeIs('cart') ? 'active' : '' }}">
                   <i class="fas fa-shopping-cart"></i>
                   <span class="hidden sm:inline">Cart</span>
                   @php
                       $cartCount = session('cart') ? count(session('cart')) : 0;
                   @endphp
                   @if($cartCount > 0)
                       <span class="cart-badge">{{ $cartCount }}</span>
                   @endif
                </a>
                @endif

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>

                {{-- Avatar --}}
                @php
                    $avatar = Auth::user()->avatar && file_exists(storage_path('app/public/' . Auth::user()->avatar))
                        ? asset('storage/' . Auth::user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=764ba2&color=fff&size=128';
                @endphp
                <img src="{{ $avatar }}" 
                     alt="User Avatar" 
                     class="avatar-small" 
                     title="{{ Auth::user()->name }}"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=764ba2&color=fff&size=128'">
            </div>
        </nav>
    @endauth

    <!-- Main Content -->
    <main class="main-content">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="fade-in p-4 mb-4 text-green-800 bg-green-100 border border-green-400 rounded mx-4 mt-4" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="fade-in p-4 mb-4 text-red-800 bg-red-100 border border-red-400 rounded mx-4 mt-4" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="fade-in p-4 mb-4 text-red-800 bg-red-100 border border-red-400 rounded mx-4 mt-4" role="alert">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="font-medium">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Page-specific scripts -->
    @yield('scripts')

    <!-- Global JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Add loading states to all buttons inside forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const buttons = this.querySelectorAll('button[type="submit"]');
                    buttons.forEach(button => {
                        button.disabled = true;
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                        button.dataset.originalText = originalText;
                        
                        // Re-enable button if form submission fails
                        setTimeout(() => {
                            if (button.disabled) {
                                button.disabled = false;
                                button.innerHTML = button.dataset.originalText;
                            }
                        }, 10000);
                    });
                });
            });

            // Mobile menu toggle (if needed in future)
            console.log('Elchapo Café loaded successfully!');
        });

        // Utility function to format currency
        function formatCurrency(amount) {
            return 'Kshs ' + parseInt(amount).toLocaleString();
        }

        // Utility function to handle API errors
        function handleApiError(error) {
            console.error('API Error:', error);
            alert('An error occurred. Please try again.');
        }
    </script>
</body>
</html>