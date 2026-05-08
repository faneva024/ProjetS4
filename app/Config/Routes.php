<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post(
    '/wallet/recharge',
    'WalletController::recharge'
);

$routes->post(
    '/gold/upgrade',
    'GoldController::upgrade'
);

$routes->group('admin', ['filter' => 'admin'], function($routes){

    $routes->get(
        '/',
        'AdminController::index'
    );

});

$routes->post(
    '/subscription/subscribe',
    'SubscriptionController::subscribe'
);

$routes->get(
    '/admin/sports',
    'SportController::index',
    ['filter' => 'admin']
);

$routes->post(
    '/admin/sports/create',
    'SportController::create',
    ['filter' => 'admin']
);

$routes->get(
    '/admin/sports/delete/(:num)',
    'SportController::delete/$1',
    ['filter' => 'admin']
);

