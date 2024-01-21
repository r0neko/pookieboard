<?php

namespace App\PookieBoard\Modules\Navigation;

class AbstractNavigationItem
{
    protected $name;
    protected $icon;

    /**
     * @param $name
     * @param $icon
     */
    public function __construct($name, $icon = null)
    {
        $this->name = $name;
        $this->icon = $icon;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function isVisible(): bool
    {
        return true;
    }

    final public function getName(): string {
        return $this->name;
    }

    final public function getFriendlyName(): string {
        // split camelCase to words, then join them with lines,
        // and return the lowercase version of the new string
        return strtolower(implode('-', preg_split('/(?<=\\w)(?=[A-Z])/', str_replace(' ', '-', $this->name))));
    }

    final public function getIcon(): mixed
    {
        return $this->icon;
    }

    final public function setIcon(mixed $icon): void
    {
        $this->icon = $icon;
    }
}
