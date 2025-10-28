<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Elchapo Café' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[url('/images/coffee-bg.jpg')] bg-cover bg-center bg-fixed min-h-screen font-sans text-amber-900">
    <!-- Navbar -->
    <nav class="bg-amber-800 bg-opacity-90 text-white py-4 shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6">
            <h1 class="text-2xl font-bold tracking-wide">☕ Elchapo Café</h1>
            <ul class="flex space-x-8 text-lg">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'text-yellow-400 border-b-2 border-yellow-400' : 'hover:text-yellow-400' }}">
                       Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}"
                       class="{{ request()->routeIs('products.*') ? 'text-yellow-400 border-b-2 border-yellow-400' : 'hover:text-yellow-400' }}">
                       Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}"
                       class="{{ request()->routeIs('orders.*') ? 'text-yellow-400 border-b-2 border-yellow-400' : 'hover:text-yellow-400' }}">
                       Orders
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="pt-24 container mx-auto px-6">
        {{ $slot }}
    </div>
</body>
</html>
