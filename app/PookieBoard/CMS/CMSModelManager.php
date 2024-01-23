<?php

namespace App\PookieBoard\CMS;

class CMSModelManager
{
    protected $models = [];

    public function registerModel(string $name, $modelClass) {
        $this->models[$name] = $modelClass;
    }

    public function getModel(string $name) {
        return $this->models[$name];
    }
}

