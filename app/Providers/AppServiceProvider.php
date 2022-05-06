<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

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
