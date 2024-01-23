<?php

namespace App\PookieBoard\Providers;

use App\PookieBoard\CMS\CMSModelManager;
use Illuminate\Support\ServiceProvider;

class CMSModelServiceProvider extends ServiceProvider
{
    public function register() {
        // register CMS Model Manager in DI
        $this->app->singleton('cms.models', function ($app) {
            return new CMSModelManager();
        });
    }
}
