<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS specifically for Vercel's Load Balancer Edge Termination 
        // to prevent Mixed Content CSS warnings and 308 POST drop '419 Expired' loops
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Set "Remember Me" cookie to last 30 days (in minutes)
        Auth::guard('web')->setRememberDuration(60 * 24 * 30);
    }
}
