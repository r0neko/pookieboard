<?php

namespace App\PookieBoard\UI;

abstract class AbstractIconProvider
{
    protected $icon;

    /**
     * @param $icon
     */
    public function __construct($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    final public function getIcon()
    {
        return $this->icon;
    }

    public function render(string $extraClasses = ""): string {
        return "";
    }
}
