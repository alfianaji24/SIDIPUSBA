<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('display', ['namespace' => 'App\Modules\Display\Controllers'], function($routes){
	$routes->add('/', 'Display::index');
});

$routes->group('api', ['namespace' => 'App\Modules\Display\Controllers\Api'], function($routes){
    $routes->get('display/layoutaktif', 'Display::layoutAktif');
});