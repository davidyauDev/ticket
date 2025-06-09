<?php

namespace App\Providers;

use App\Models\Area;
use Illuminate\Support\Facades\View;

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
        View::share('areas', Area::with('children')->whereNull('parent_id')->orderBy('nombre')->get());
    }
}
