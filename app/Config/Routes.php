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