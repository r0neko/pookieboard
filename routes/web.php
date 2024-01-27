<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/admin', [
    'as' => 'cms.home',
    'uses' => 'AdminController@index'
]);

// Module Management
$router->get('/admin/modules', [
    'as' => 'cms.modules',
    'uses' => 'ModulesController@index'
]);

$router->get('/admin/module/{module}/activate', [
    'as' => 'cms.module.activate',
    'uses' => 'ModulesController@activate'
]);

$router->get('/admin/module/{module}/deactivate', [
    'as' => 'cms.module.deactivate',
    'uses' => 'ModulesController@deactivate'
]);

// Model Management
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

// Media and bundle Management
$router->get('/media/{id}', 'MediaController@getMedia');
$router->get('/bundles/{file:.*}', 'BundleController@getBundleFile');
