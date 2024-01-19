<?php

namespace App\PookieBoard\UI;

class FontAwesomeIconProvider extends AbstractIconProvider
{
    protected $style;

    public function __construct($icon, $style)
    {
        parent::__construct($icon);
        $this->style = $style;
    }

    public function render(string $extraClasses = ""): string {
        return "<i class=\"fa-{$this->style} fa-{$this->icon} {$extraClasses}\"></i>";
    }
}
