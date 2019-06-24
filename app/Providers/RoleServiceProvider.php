<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\HelperClass\Helping;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Helping::if('role',function($role){
        //     return auth()->check() && auth()->user()->hasRole($role);
        // });
        Blade::if('role',function($role){
            return auth()->check() && auth()->user()->hasRole($role);
        });
    }
}
