<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('', ['filter' => 'auth', 'namespace' => 'App\Modules\Sekolah\Controllers'], function($routes){
	$routes->get('guru', 'Sekolah::guru');
    $routes->get('kelas', 'Sekolah::kelas');
    $routes->get('haribelajar', 'Sekolah::hariBelajar');
    $routes->get('jampelajaran', 'Sekolah::jamPelajaran');
    $routes->get('jadwalpelajaran', 'Sekolah::jadwalPelajaran');
});

$routes->group('api', ['namespace' => 'App\Modules\Sekolah\Controllers\Api'], function($routes){
    $routes->get('display/guru', 'Guru::display');
    $routes->get('display/kelas', 'Kelas::display');
    $routes->get('display/haribelajar', 'Haribelajar::display');
    $routes->get('display/jampelajaran', 'Jampelajaran::display');
    $routes->get('display/jadwalpelajaran', 'Jadwalpelajaran::display');
    $routes->get('display/jadwalpelajaran2', 'Jadwalpelajaran::display2');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Sekolah\Controllers\Api'], function($routes){
    $routes->get('guru', 'Guru::index');
    $routes->post('guru/save', 'Guru::create');
    $routes->put('guru/update/(:segment)', 'Guru::update/$1');
	$routes->delete('guru/delete/(:segment)', 'Guru::delete/$1');
    $routes->post('guru/upload', 'Guru::upload');

    $routes->get('kelas', 'Kelas::index');
    $routes->post('kelas/save', 'Kelas::create');
    $routes->put('kelas/update/(:segment)', 'Kelas::update/$1');
	$routes->delete('kelas/delete/(:segment)', 'Kelas::delete/$1');

    $routes->get('jampelajaran', 'Jampelajaran::index');
    $routes->get('jampelajaran/(:segment)', 'Jampelajaran::show/$1');
    $routes->post('jampelajaran/save', 'Jampelajaran::create');
    $routes->put('jampelajaran/update/(:segment)', 'Jampelajaran::update/$1');
	$routes->delete('jampelajaran/delete/(:segment)', 'Jampelajaran::delete/$1');

    $routes->get('haribelajar', 'Haribelajar::index');
    $routes->get('haribelajar/(:segment)', 'Haribelajar::show/$1');
    $routes->post('haribelajar/save', 'Haribelajar::create');
    $routes->put('haribelajar/update/(:segment)', 'Haribelajar::update/$1');
	$routes->delete('haribelajar/delete/(:segment)', 'Haribelajar::delete/$1');
    $routes->get('harijambelajar', 'Haribelajar::belajar');

    $routes->get('jadwalpelajaran', 'Jadwalpelajaran::index');
    $routes->get('jadwalpelajaran/(:segment)', 'Jadwalpelajaran::show/$1');
    $routes->post('jadwalpelajaran/save', 'Jadwalpelajaran::create');
    $routes->put('jadwalpelajaran/update/(:segment)', 'Jadwalpelajaran::update/$1');
	$routes->delete('jadwalpelajaran/delete/(:segment)', 'Jadwalpelajaran::delete/$1');
    
});