<x-app-layout>
    <x-slot name="title">Dashboard - Elchapo</x-slot>

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
            background: rgba(118, 75, 162, 0.9);
            color: white;
            padding: 0.8rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            z-index: 1000;
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
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffd966; /* soft gold hover */
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

        /* === MAIN DASHBOARD === */
        .dashboard-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 120px; /* Offset for navbar */
            padding-bottom: 50px;
        }

        .welcome-text {
            font-weight: bold;
            color: white;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            font-size: 2.6rem;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 0.6rem 1rem;
            }
            .nav-link {
                font-size: 0.9rem;
            }
            .avatar-small {
                width: 40px;
                height: 40px;
            }
            .welcome-text {
                font-size: 1.8rem;
            }
        }
    </style>

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
           class="nav-link {{ request()->routeIs('dashboard') ? 'font-bold text-white underline' : '' }}">
           Dashboard
        </a>

        <a href="{{ route('products.index') }}" 
           class="nav-link {{ request()->routeIs('products.*') ? 'font-bold text-white underline' : '' }}">
           Products
        </a>

        <a href="{{ route('orders.index') }}" 
           class="nav-link {{ request()->routeIs('orders.*') ? 'font-bold text-white underline' : '' }}">
           Orders
        </a>

        <li class="nav-item">
    <a class="nav-link" href="{{ route('cart') }}">
        Cart 
        @if(session('cart'))
            <span class="badge bg-danger">{{ count(session('cart')) }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('orders.index') }}">My Orders</a>
</li>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="nav-link text-red-300 hover:text-red-500 transition">
                Logout
            </button>
        </form>

        {{-- Avatar --}}
        @php
            $avatar = Auth::user()->avatar 
                ? asset('storage/' . Auth::user()->avatar)
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=764ba2&color=fff';
        @endphp
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

        <p class="welcome-text">Welcome to Elchapo ☕, {{ Auth::user()->name }}!</p>
    </div>
</x-app-layout>
