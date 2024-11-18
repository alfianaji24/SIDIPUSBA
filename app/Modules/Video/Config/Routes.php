<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('video', ['filter' => 'auth', 'namespace' => 'App\Modules\Video\Controllers'], function($routes){
	$routes->get('/', 'Video::index');
});

$routes->group('api', ['namespace' => 'App\Modules\Video\Controllers\Api'], function($routes){
    $routes->get('display/video', 'Video::display');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Video\Controllers\Api'], function($routes){
    $routes->get('video', 'Video::index');
    $routes->post('video/save', 'Video::create');
    $routes->put('video/update/(:segment)', 'Video::update/$1');
	$routes->delete('video/delete/(:segment)', 'Video::delete/$1');
    $routes->post('video/upload', 'Video::upload');
    $routes->put('video/setaktif/(:segment)', 'Video::setAktif/$1');
    $routes->post('video/plupload', 'Video::plupload');
    $routes->delete('video/plupload/delete/delete_uploaded', 'Video::delete_uploaded');
});