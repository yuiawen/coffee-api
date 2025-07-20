<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Api\Coffees::index');

$routes->group('api', static function ($routes) {
    
    // --- Rute Publik (Tidak Perlu Login) ---
    // Auth
    $routes->post('register', 'Api\Auth::register');
    $routes->post('login',    'Api\Auth::login');

    // Coffees (Read-Only)
    $routes->get('coffees',      'Api\Coffees::index');
    $routes->get('coffees/(:num)', 'Api\Coffees::show/$1');

    // Foods (Read-Only)
    $routes->get('foods',      'Api\Foods::index');
    $routes->get('foods/(:num)', 'Api\Foods::show/$1');

    // --- Grup Rute Terproteksi (Wajib Login/Kirim Token) ---
    $routes->group('', ['filter' => 'jwtauth'], static function ($routes) {
        
        // Coffees (Create, Update, Delete)
        $routes->post('coffees',          'Api\Coffees::create');
        $routes->put('coffees/(:num)',   'Api\Coffees::update/$1');
        $routes->delete('coffees/(:num)','Api\Coffees::delete/$1');

        // Foods (Create, Update, Delete)
        $routes->post('foods',          'Api\Foods::create');
        $routes->put('foods/(:num)',   'Api\Foods::update/$1');
        $routes->delete('foods/(:num)','Api\Foods::delete/$1');
    });

});
