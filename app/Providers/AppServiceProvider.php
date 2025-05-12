<?php

namespace App\Providers;

use App\Models\LoadEntry;
use App\Policies\LoadPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Pump;
use App\Policies\PumpPolicy;

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
        Gate::policy(LoadEntry::class, LoadPolicy::class);
        Gate::policy(Pump::class, PumpPolicy::class);
    }
}
