@php
    $avatar = Auth::user()->avatar
        ? asset('storage/' . Auth::user()->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=764ba2&color=fff';
@endphp

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