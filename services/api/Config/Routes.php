<?php
/**
 * @project ptpmhdv-nhom-7
 * @email honghoaphong19@gmail.com
 * @date 14/11/2024
 * @time 14:54
 */

use Api\Controllers\Category;
use Api\Controllers\Item;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', static function ($routes) {
    $routes->group('items', static function ($routes) {
        $routes->get('/', [Item::class, 'index']);
        $routes->get('show/(:num)', [Item::class, 'show']);
        $routes->post('create', [Item::class, 'create']);
        $routes->post('update/(:num)', [Item::class, 'update']);
        $routes->post('delete/(:num)', [Item::class, 'delete']);
    });

    $routes->group('categories', static function ($routes) {
        $routes->get('/', [Category::class, 'index']);
        $routes->post('show/(:num)', [Category::class, 'show']);
        $routes->post('create', [Category::class, 'create']);
        $routes->post('update/(:num)', [Category::class, 'update']);
        $routes->post('delete/(:num)', [Category::class, 'delete']);
    });
});
