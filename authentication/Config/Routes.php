<?php

use Auth\Controllers\Login;
use Auth\Controllers\Register;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('auth', static function ($routes) {
    $routes->get('login', [Login::class, 'loginView']);
    $routes->post('login', [Login::class, 'loginAction']);

    $routes->get('logout', [Login::class, 'logoutAction']);

    $routes->get('register', [Register::class, 'registerView']);
    $routes->post('register', [Register::class, 'registerAction']);
});
