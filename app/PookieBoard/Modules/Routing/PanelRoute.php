<?php

namespace App\PookieBoard\Modules\Routing;

class PanelRoute
{
    protected $name;
    protected $route;
    protected $icon;

    /**
     * @param $name
     * @param $route
     * @param $icon
     */
    public function __construct($name, $route, $icon = null)
    {
        $this->name = $name;
        $this->route = $route;
        $this->icon = $icon;
    }

    public function isActive(): bool
    {
        return request()->routeIs($this->route);
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getRoute(): string {
        return $this->route;
    }

    public function getIcon(): mixed
    {
        return $this->icon;
    }

    public function setIcon(mixed $icon): void
    {
        $this->icon = $icon;
    }

    public function render(): string
    {
        return view('cms.page.components.sidebar.singular-route', [
            "panelRoute" => $this
        ])->render();
    }
}
