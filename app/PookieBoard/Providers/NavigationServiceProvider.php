<?php

namespace App\PookieBoard\Providers;

use App\PookieBoard\Modules\Navigation\NavigationItem;
use App\PookieBoard\Modules\Navigation\NavigationItemCollection;
use App\PookieBoard\UI\FontAwesomeIconProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->singleton('cms.sidebar.navigation', function ($app) {
            return new NavigationItemCollection();
        });
    }

    public function boot() {
        $panelRoutes = app('cms.sidebar.navigation');

        $panelRoutes->add(new NavigationItem("Home", "cms.home", new FontAwesomeIconProvider("house", "solid")));
        $panelRoutes->add(new NavigationItem("Modules", "cms.modules", new FontAwesomeIconProvider("puzzle-piece", "solid")));

        View::composer('*', function ($view) {
            $panelRoutes = $this->app->make('cms.sidebar.navigation');
            $view->with('cmsSidebarItems', $panelRoutes);
        });
    }
}
