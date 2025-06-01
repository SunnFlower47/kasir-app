<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

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
        Blade::if('canSee', function ($roles) {
            $roles = is_array($roles) ? $roles : explode(',', $roles);
            return Auth::check() && in_array(Auth::user()->role, $roles);
        });
    }

}
