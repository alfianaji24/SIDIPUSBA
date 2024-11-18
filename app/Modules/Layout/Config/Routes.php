<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('layout', ['filter' => 'auth', 'namespace' => 'App\Modules\Layout\Controllers'], function($routes){
	$routes->get('/', 'Layout::index');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Layout\Controllers\Api'], function($routes){
    $routes->get('layout', 'Layout::index');
    $routes->post('layout/save', 'Layout::create');
    $routes->put('layout/update/(:segment)', 'Layout::update/$1');
	$routes->delete('layout/delete/(:segment)', 'Layout::delete/$1');
});