<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('ruang', ['filter' => 'auth', 'namespace' => 'App\Modules\Ruang\Controllers'], function($routes){
	$routes->add('/', 'Ruang::index');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Ruang\Controllers\Api'], function($routes){
	$routes->get('ruang', 'Ruang::index');
	$routes->get('ruang/(:segment)', 'Ruang::show/$1');
	$routes->post('ruang/save', 'Ruang::create');
	$routes->put('ruang/update/(:segment)', 'Ruang::update/$1');
	$routes->delete('ruang/delete/(:segment)', 'Ruang::delete/$1');
	$routes->get('ruang_kampus', 'Ruang::kampus');
	$routes->get('ruang_sekolah', 'Ruang::sekolah');
	$routes->get('ruang_rsklinik', 'Ruang::rsklinik');
});