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


/**
 * @var RouteCollection $routes
 */
$routes->group('api', function($routes) {
    // Routes publiques
    $routes->post('register', 'Api\AuthController::register');
    $routes->post('login', 'Api\AuthController::login');
    
    // Routes privées (protégées par le middleware 'auth')
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('logout', 'Api\AuthController::logout');
        
        // Profil & Dashboard
        $routes->get('profile', 'Api\DashboardController::profile'); // A implémenter si besoin
        $routes->get('imc', 'Api\DashboardController::imc');
        
        // Objectifs
        $routes->post('objectif', 'Api\ObjectiveController::updateObjective');
        $routes->put('objectif', 'Api\ObjectiveController::updateObjective');
        
        // Poids
        $routes->post('weight', 'Api\WeightController::addWeight');
        $routes->get('weight-history', 'Api\WeightController::getHistory');
        $routes->get('weight-chart', 'Api\WeightController::getChartData');
        
        // Suggestions
        $routes->get('regimes/suggestions', 'Api\SuggestionController::getRegimes');
        $routes->get('sports/suggestions', 'Api\SuggestionController::getSports');
        
        // PDF
        $routes->get('pdf/rapport', 'Api\PdfController::downloadRapport');
    });
});