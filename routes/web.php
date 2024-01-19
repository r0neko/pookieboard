<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/admin', [
    'as' => 'cms.home',
    'uses' => 'AdminController@index'
]);

$router->get('/admin/modules', [
    'as' => 'cms.modules',
    'uses' => 'ModulesController@index'
]);
