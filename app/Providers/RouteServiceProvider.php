<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path to redirect users after login
     */
    public const HOME = '/dashboard';

    /**
     * Define your routes
     */
    public function boot(): void
    {
        $this->routes(function () {
            // ✅ Only web routes (no API)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
