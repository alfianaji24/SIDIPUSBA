<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('agenda', ['filter' => 'auth', 'namespace' => 'App\Modules\Agenda\Controllers'], function($routes){
	$routes->get('/', 'Agenda::index');
});

$routes->group('api', ['namespace' => 'App\Modules\Agenda\Controllers\Api'], function($routes){
    $routes->get('display/agenda', 'Agenda::display');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Agenda\Controllers\Api'], function($routes){
    $routes->get('agenda', 'Agenda::index');
    $routes->post('agenda/save', 'Agenda::create');
    $routes->put('agenda/update/(:segment)', 'Agenda::update/$1');
	$routes->delete('agenda/delete/(:segment)', 'Agenda::delete/$1');
});