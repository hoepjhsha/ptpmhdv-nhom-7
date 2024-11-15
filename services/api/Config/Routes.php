<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
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
        $routes->post('/show/(:segment)', [Item::class, 'show/:1']);
        $routes->post('/create', [Item::class, 'create']);
        $routes->post('/update/(:segment)', [Item::class, 'update/:1']);
        $routes->post('/delete/(:segment)', [Item::class, 'delete/:1']);
    });

    $routes->group('categories', static function ($routes) {
        $routes->get('/', [Category::class, 'index']);
        $routes->post('/show/(:segment)', [Category::class, 'show/:1']);
        $routes->post('/create', [Category::class, 'create']);
        $routes->post('/update/(:segment)', [Category::class, 'update/:1']);
        $routes->post('/delete/(:segment)', [Category::class, 'delete/:1']);
    });
});
