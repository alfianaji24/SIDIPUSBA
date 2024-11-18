<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('custom', ['filter' => 'auth', 'namespace' => 'App\Modules\Custom\Controllers'], function($routes){
	$routes->add('/', 'Custom::index');
});

$routes->group('api', ['namespace' => 'App\Modules\Custom\Controllers\Api'], function($routes){
    $routes->get('display/custom', 'Custom::display');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Custom\Controllers\Api'], function($routes){
    $routes->get('custom', 'Custom::index');
	$routes->post('custom/save', 'Custom::create');
	$routes->put('custom/update/(:segment)', 'Custom::update/$1');
	$routes->delete('custom/delete/(:segment)', 'Custom::delete/$1');
	$routes->put('custom/setaktif/(:segment)', 'Custom::setAktif/$1');
});