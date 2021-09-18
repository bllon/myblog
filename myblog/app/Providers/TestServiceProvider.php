<?php

namespace App\Providers;
use App\Common\Auth\JwtAuth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Common\Auth\Auth;

class TestServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('Auth','JwtAuth');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function provides()
    {
        return [Auth::class];
    }
}
