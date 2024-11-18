<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('galeri', ['filter' => 'auth', 'namespace' => 'App\Modules\Galeri\Controllers'], function($routes){
	$routes->get('/', 'Galeri::index');
});

$routes->group('api', ['namespace' => 'App\Modules\Galeri\Controllers\Api'], function($routes){
    $routes->get('display/galeri', 'Galeri::display');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Galeri\Controllers\Api'], function($routes){
    $routes->get('galeri', 'Galeri::index');
    $routes->post('galeri/save', 'Galeri::create');
    $routes->put('galeri/update/(:segment)', 'Galeri::update/$1');
	$routes->delete('galeri/delete/(:segment)', 'Galeri::delete/$1');
    $routes->post('galeri/upload', 'Galeri::upload');
    $routes->put('galeri/setaktif/(:segment)', 'Galeri::setAktif/$1');
});