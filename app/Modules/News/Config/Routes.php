<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('news', ['filter' => 'auth', 'namespace' => 'App\Modules\News\Controllers'], function($routes){
	$routes->get('/', 'News::index');
});

$routes->group('api', ['namespace' => 'App\Modules\News\Controllers\Api'], function($routes){
	$routes->get('news/news', 'News::news');
    $routes->get('news/info', 'News::info');
    $routes->get('news/masjid', 'News::masjid');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\News\Controllers\Api'], function($routes){
    $routes->get('news', 'News::index');
    $routes->post('news/save', 'News::create');
    $routes->put('news/update/(:segment)', 'News::update/$1');
	$routes->delete('news/delete/(:segment)', 'News::delete/$1');
});