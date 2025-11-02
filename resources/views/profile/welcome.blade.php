<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to elchapo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* Simplified styles for demonstration */
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #FDFDFC;
                color: #1b1b18;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            
            .container {
                max-width: 1200px;
                width: 100%;
                padding: 2rem;
            }
            
            .welcome-card {
                background: white;
                border-radius: 0.5rem;
                padding: 3rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            
            h1 {
                font-size: 3rem;
                color: #f53003;
                margin-bottom: 1rem;
            }
            
            p {
                font-size: 1.25rem;
                color: #706f6c;
                margin-bottom: 2rem;
            }
            
            .btn {
                display: inline-block;
                background: #1b1b18;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 0.25rem;
                text-decoration: none;
                font-weight: 500;
                transition: background-color 0.2s;
            }
            
            .btn:hover {
                background: #000;
            }
            
            .nav {
                display: flex;
                justify-content: flex-end;
                gap: 1rem;
                margin-bottom: 2rem;
            }
            
            .nav a {
                color: #1b1b18;
                text-decoration: none;
                padding: 0.5rem 1rem;
                border: 1px solid transparent;
                border-radius: 0.25rem;
            }
            
            .nav a:hover {
                border-color: #19140035;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <nav class="nav">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>

            <div class="welcome-card">
                <h1>Welcome to elchapo</h1>
                <p>We're excited to have you here! Get started with our amazing platform.</p>
                
                <div style="margin-bottom: 2rem;">
                    <a href="{{ route('products.index') }}" class="btn">Explore Products</a>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('products.index') }}" style="color: #f53003; text-decoration: none;">
                        Browse Products →
                    </a>
                    <a href="{{ route('dashboard') }}" style="color: #f53003; text-decoration: none;">
                        View Dashboard →
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>