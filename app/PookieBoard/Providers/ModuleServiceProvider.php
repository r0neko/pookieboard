<?php

namespace App\PookieBoard\Providers;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register() {
        // register ModuleManager in DI
        $this->app->singleton(ModuleManager::class, function ($app) {
            return new ModuleManager();
        });

        // get ModuleManager from DI and load packages
        $manager = app(ModuleManager::class);

        $manager->loadPackages();
        $manager->registerPackages();
    }
}
