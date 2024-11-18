<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('', ['filter' => 'auth', 'namespace' => 'App\Modules\RsKlinik\Controllers'], function($routes){
	$routes->get('dokter', 'Rsklinik::dokter');
    $routes->get('ruangan', 'Rsklinik::ruangan');
    $routes->get('harilayanan', 'Rsklinik::hariLayanan');
    $routes->get('jampelayanan', 'Rsklinik::jamPelayanan');
    $routes->get('jadwaldokter', 'Rsklinik::jadwalDokter');
});

$routes->group('api', ['namespace' => 'App\Modules\RsKlinik\Controllers\Api'], function($routes){
    $routes->get('display/dokter', 'Dokter::display');
    $routes->get('display/ruang', 'Ruang::display');
    $routes->get('display/harilayanan', 'Harilayanan::display');
    $routes->get('display/jampelayanan', 'Jampelayanan::display');
    $routes->get('display/jadwaldokter', 'Jadwaldokter::display');
    $routes->get('display/jadwaldokter2', 'Jadwaldokter::display2');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\RsKlinik\Controllers\Api'], function($routes){
    $routes->get('dokter', 'Dokter::index');
    $routes->post('dokter/save', 'Dokter::create');
    $routes->put('dokter/update/(:segment)', 'Dokter::update/$1');
	$routes->delete('dokter/delete/(:segment)', 'Dokter::delete/$1');
    $routes->post('dokter/upload', 'Dokter::upload');

    $routes->get('jampelayanan', 'Jampelayanan::index');
    $routes->get('jampelayanan/(:segment)', 'Jampelayanan::show/$1');
    $routes->post('jampelayanan/save', 'Jampelayanan::create');
    $routes->put('jampelayanan/update/(:segment)', 'Jampelayanan::update/$1');
	$routes->delete('jampelayanan/delete/(:segment)', 'Jampelayanan::delete/$1');

    $routes->get('harilayanan', 'Harilayanan::index');
    $routes->get('harilayanan/(:segment)', 'Harilayanan::show/$1');
    $routes->post('harilayanan/save', 'Harilayanan::create');
    $routes->put('harilayanan/update/(:segment)', 'Harilayanan::update/$1');
	$routes->delete('harilayanan/delete/(:segment)', 'Harilayanan::delete/$1');
    $routes->get('harijamlayanan', 'Harilayanan::layanan');

    $routes->get('jadwaldokter', 'Jadwaldokter::index');
    $routes->get('jadwaldokter/(:segment)', 'Jadwaldokter::show/$1');
    $routes->post('jadwaldokter/save', 'Jadwaldokter::create');
    $routes->put('jadwaldokter/update/(:segment)', 'Jadwaldokter::update/$1');
	$routes->delete('jadwaldokter/delete/(:segment)', 'Jadwaldokter::delete/$1');
    
});