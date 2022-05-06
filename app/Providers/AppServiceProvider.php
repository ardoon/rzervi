<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin', function (User $user){
            return $user->type === 'admin';
        });

        Gate::define('provider', function (User $user){
            return $user->type === 'provider';
        });

        Gate::define('customer', function (User $user){
            return $user->type === 'customer';
        });
    }
}
