<?php

namespace App\PookieBoard\Providers;

use App\PookieBoard\Modules\Routing\PanelRoute;
use App\PookieBoard\Modules\Routing\PanelRouteCollection;
use App\PookieBoard\UI\FontAwesomeIconProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PanelRoutingServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->singleton(PanelRouteCollection::class, function ($app) {
            return new PanelRouteCollection();
        });
    }

    public function boot() {
        $panelRoutes = app(PanelRouteCollection::class);

        $panelRoutes->add(new PanelRoute("Home", "cms.home", new FontAwesomeIconProvider("house", "solid")));
        $panelRoutes->add(new PanelRoute("Modules", "cms.modules", new FontAwesomeIconProvider("puzzle-piece", "solid")));

        View::composer('*', function ($view) {
            $panelRoutes = $this->app->make(PanelRouteCollection::class);
            $view->with('panelRoutes', $panelRoutes);
        });
    }
}
