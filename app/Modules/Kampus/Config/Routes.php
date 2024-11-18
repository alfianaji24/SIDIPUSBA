<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('', ['filter' => 'auth', 'namespace' => 'App\Modules\Kampus\Controllers'], function($routes){
	$routes->get('dosen', 'Kampus::dosen');
    $routes->get('skripsi', 'Kampus::skripsi');
});

$routes->group('api', ['namespace' => 'App\Modules\Kampus\Controllers\Api'], function($routes){
    $routes->get('display/dosen', 'Dosen::display');
    $routes->get('display/skripsi', 'Skripsi::display');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Kampus\Controllers\Api'], function($routes){
    $routes->get('dosen', 'Dosen::index');
    $routes->post('dosen/save', 'Dosen::create');
    $routes->put('dosen/update/(:segment)', 'Dosen::update/$1');
	$routes->delete('dosen/delete/(:segment)', 'Dosen::delete/$1');
    $routes->post('dosen/upload', 'Dosen::upload');

    $routes->get('skripsi', 'Skripsi::index');
    $routes->post('skripsi/save', 'Skripsi::create');
    $routes->put('skripsi/update/(:segment)', 'Skripsi::update/$1');
	$routes->delete('skripsi/delete/(:segment)', 'Skripsi::delete/$1');
});