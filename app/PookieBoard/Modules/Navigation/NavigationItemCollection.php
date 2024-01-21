<?php

namespace App\PookieBoard\Modules\Navigation;

class NavigationItemCollection
{
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(AbstractNavigationItem $route)
    {
        $this->items[] = $route;
    }

    public function remove(AbstractNavigationItem $route)
    {
        $this->items = array_filter($this->items, fn($r) => $r !== $route);
    }

    public function getItems()
    {
        return $this->items;
    }
}
