<?php

namespace App\PookieBoard\Modules\Routing;

class PanelRouteCollection
{
    protected $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function add(PanelRoute $route)
    {
        $this->routes[] = $route;
    }

    public function remove(PanelRoute $route)
    {
        $this->routes = array_filter($this->routes, fn($r) => $r !== $route);
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
