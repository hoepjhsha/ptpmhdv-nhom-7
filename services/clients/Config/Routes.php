<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 11:19
 */

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Client\Controllers\Home::class, 'index']);
$routes->get('home', [Client\Controllers\Home::class, 'index']);
