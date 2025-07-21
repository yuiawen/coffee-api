<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- WEB ROUTES ---
$routes->get('/', 'Web\Dashboard::index');
$routes->get('/dashboard', 'Web\Dashboard::index');
$routes->resource('coffees', ['controller' => 'Web\Coffees']);
$routes->resource('foods', ['controller' => 'Web\Foods']);

// --- API ROUTES ---
$routes->group('api', static function ($routes) {
    
    // Public API Routes
    $routes->post('register', 'Api\Auth::register');
    $routes->post('login',    'Api\Auth::login');
    $routes->get('coffees',      'Api\Coffees::index');
    $routes->get('coffees/(:num)', 'Api\Coffees::show/$1');
    $routes->get('foods',      'Api\Foods::index');
    $routes->get('foods/(:num)', 'Api\Foods::show/$1');

    // Protected API Routes
    $routes->group('', ['filter' => 'jwtauth'], static function ($routes) {
        $routes->post('coffees',          'Api\Coffees::create');
        $routes->put('coffees/(:num)',   'Api\Coffees::update/$1');
        $routes->delete('coffees/(:num)','Api\Coffees::delete/$1');
        $routes->post('foods',          'Api\Foods::create');
        $routes->put('foods/(:num)',   'Api\Foods::update/$1');
        $routes->delete('foods/(:num)','Api\Foods::delete/$1');
    });

});