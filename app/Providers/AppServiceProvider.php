<?php

namespace App\Providers;

use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // register session manager
        $app = $this->app;

        $app->singleton(SessionManager::class, function () use ($app) {
            return $app->loadComponent('session', SessionServiceProvider::class, 'session');
        });

        $app->singleton('session.store', function () use ($app) {
            return $app->loadComponent('session', SessionServiceProvider::class, 'session.store');
        });
    }
}
