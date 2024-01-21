<?php

namespace App\PookieBoard\Modules\Navigation;
class NestedNavigationItemCollection extends AbstractNavigationItem
{
    protected $items;

    public function __construct($name, $icon = null)
    {
        parent::__construct($name, $icon);
        $this->items = [];
    }

    public function add(NavigationItem $route)
    {
        $this->items[] = $route;
    }

    public function remove(NavigationItem $route)
    {
        $this->items = array_filter($this->items, fn($r) => $r !== $route);
    }

    public function getItems() {
        return $this->items;
    }

    public function isActive(): bool
    {
        // loop through each item in the collection
        // and if we find an active item, we return true;
        // otherwise false

        foreach($this->items as $item) {
            if($item->isActive()) return true;
        }

        return false;
    }
}
