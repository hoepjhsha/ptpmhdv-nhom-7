<?php

/**
 * ----------------------------------------------------------------
 *  Define Auth Routes
 * ----------------------------------------------------------------
 */
$routes->group('auth', static function ($routes) {
    $routes->get('login', '\Auth\Controllers\Auth::login');
    $routes->post('login', '\Auth\Controllers\Auth::login');
    $routes->get('logout', '\Auth\Controllers\Auth::logout');
});
