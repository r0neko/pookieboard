<?php

namespace App\PookieBoard\Modules\Navigation;

class ModelNavigationItem extends NavigationItem
{
    protected $model;

    /**
     * @param $name
     * @param $model
     * @param $icon
     */
    public function __construct($name, $model, $icon = null)
    {
        parent::__construct($name, null, $icon);
        $this->model = $model;
    }

    public function isActive(): bool
    {
        $routes = ["cms.model.all", "cms.model.new", "cms.model.edit"];
        foreach($routes as $route) {
            if(str_starts_with(request()->url(), route($route, ["model" => $this->model]))) {
                return true;
            }
        }

        return false;
    }

    public function getUrl(): string {
        return route("cms.model.all", ["model" => $this->model]);
    }
}
