<?php

namespace App\PookieBoard\Providers;

use Illuminate\Support\ServiceProvider;

class VersionServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->singleton('cms.version', function ($app) {
            return 'v0.10.8';
        });
    }
}
