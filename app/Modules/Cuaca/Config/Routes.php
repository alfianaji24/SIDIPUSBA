<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('cuaca', ['filter' => 'auth', 'namespace' => 'App\Modules\Cuaca\Controllers'], function($routes){
	$routes->get('/', 'Cuaca::index');
});

$routes->group('api', ['namespace' => 'App\Modules\Cuaca\Controllers\Api'], function($routes){
    $routes->get('display/cuaca', 'Cuaca::display');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Cuaca\Controllers\Api'], function($routes){
    $routes->get('cuaca', 'Cuaca::index');
});