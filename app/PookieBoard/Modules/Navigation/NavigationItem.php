<?php

namespace App\PookieBoard\Modules\Navigation;

class NavigationItem extends AbstractNavigationItem
{
    protected $route;

    /**
     * @param $name
     * @param $route
     * @param $icon
     */
    public function __construct($name, $route, $icon = null)
    {
        parent::__construct($name, $icon);
        $this->route = $route;
    }

    public function isActive(): bool
    {
        return request()->routeIs($this->route);
    }

    public function getUrl(): string {
        return route($this->route);
    }
}
