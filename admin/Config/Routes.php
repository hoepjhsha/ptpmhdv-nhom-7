<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 15/11/2024
 * @time 14:23
 */

use Admin\Controllers\Category;
use Admin\Controllers\Home;
use Admin\Controllers\Item;
use Admin\Controllers\User;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('admin', static function ($routes) {
    $routes->get('/', [Home::class, 'index']);
    $routes->get('home', [Home::class, 'index']);

    $routes->get('categories', [Category::class, 'index']);
    $routes->post('categories', [Category::class, 'create']);
    $routes->get('categories/(:num)/edit', [Category::class, 'edit']);
    $routes->post('categories/(:num)/edit', [Category::class, 'update']);
    $routes->get('categories/delete/(:num)', [Category::class, 'delete']);

    $routes->get('items', [Item::class, 'index']);
    $routes->get('items/create', [Item::class, 'createView']);
    $routes->post('items/create', [Item::class, 'create']);
    $routes->get('items/(:num)/edit', [Item::class, 'edit']);
    $routes->post('items/(:num)/edit', [Item::class, 'update']);
    $routes->get('items/delete/(:num)', [Item::class, 'delete']);

    $routes->get('users', [User::class, 'index']);
    $routes->get('users/create', [User::class, 'createView']);
    $routes->post('users/create', [User::class, 'create']);
    $routes->get('users/(:num)/edit', [User::class, 'edit']);
    $routes->post('users/(:num)/edit', [User::class, 'update']);
    $routes->get('users/delete/(:num)', [User::class, 'delete']);
});
