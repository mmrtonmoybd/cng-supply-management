<?php

namespace App\Providers;

use App\Models\LoadEntry;
use App\Models\Pump;
use App\Policies\LoadPolicy;
use App\Policies\PumpPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(LoadEntry::class, LoadPolicy::class);
        Gate::policy(Pump::class, PumpPolicy::class);

        Gate::define('pump_name_crud', function ($user) {
            return $user->ability(['admin'], 'pump_name_crud');
        });

        Gate::define('dispansar_crud', function ($user) {
            return $user->ability(['admin'], 'dispansar_crud');
        });

        Gate::define('weightone_crud', function ($user) {
            return $user->ability(['admin'], 'weightone_crud');
        });

        Gate::define('weight_crud', function ($user) {
            return $user->ability(['admin'], 'weight_crud');
        });

        Gate::define('cngpump_crud', function ($user) {
            return $user->ability(['admin'], 'cngpump_crud');
        });

        Gate::define('factory_crud', function ($user) {
            return $user->ability(['admin'], 'factory_crud');
        });

        Gate::define('activity_logs', function ($user) {
            return $user->ability(['admin'], 'activity_logs');
        });

        Gate::define('invoice_crud', function ($user) {
            return $user->ability(['admin'], 'invoice_crud');
        });

        Gate::define('cashbook_crud', function ($user) {
            return $user->ability(['admin'], 'cashbook_crud');
        });

        Gate::define('asset_crud', function ($user) {
            return $user->ability(['admin'], 'asset_crud');
        });

        Gate::define('vehicle_crud', function ($user) {
            return $user->ability(['admin'], 'vehicle_crud');
        });

        Gate::define('diesel_crud', function ($user) {
            return $user->ability(['admin'], 'diesel_crud');
        });

        Gate::define('transport_crud', function ($user) {
            return $user->ability(['admin'], 'transport_crud');
        });
    }
}
