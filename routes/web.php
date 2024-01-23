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

$router->get('/admin/{model}', [
    'as' => 'cms.model.all',
    'uses' => 'ModelController@showAll'
]);

$router->get('/admin/{model}/new', [
    'as' => 'cms.model.new',
    'uses' => 'ModelController@modelEditor'
]);

$router->post('/admin/{model}/new', [
    'as' => 'cms.model.new',
    'uses' => 'ModelController@saveModel'
]);

$router->get('/admin/{model}/edit/{id}', [
    'as' => 'cms.model.edit',
    'uses' => 'ModelController@modelEditor'
]);

$router->post('/admin/{model}/edit/{id}', [
    'as' => 'cms.model.edit',
    'uses' => 'ModelController@saveModel'
]);

$router->get('/admin/{model}/delete/{id}', [
    'as' => 'cms.model.delete',
    'uses' => 'ModelController@delete'
]);

// Media-related controller route
$router->get('/media/{id}', 'MediaController@getMedia');
$router->get('/bundles/{file:.*}', 'BundleController@getBundleFile');
