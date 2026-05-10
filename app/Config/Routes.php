<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('register/step1', 'AuthController::registerStep1');
$routes->post('auth/storeStep1', 'AuthController::storeStep1');

$routes->get('register/step2', 'AuthController::registerStep2');
$routes->post('auth/finalizeRegister', 'AuthController::finalizeRegister');

// Ajoutez cette ligne dans votre fichier Routes.php
$routes->post('auth/registerFull', 'AuthController::registerFull');

$routes->get('/', 'Home::index');
$routes->get('vitrine.php', 'Home::index'); // Ajout de cette ligne
$routes->get('connexion', 'Home::connexion');
$routes->get('inscription-identite', 'Home::inscriptionIdentite');
$routes->get('inscription-sante', 'Home::inscriptionSante');
$routes->get('dashboard', 'Home::dashboardUser');
$routes->get('regimes', 'Home::regimes');
$routes->get('finance', 'Home::finance');
$routes->get('admin-preview', 'Home::adminPreview');

// Compatibility with links already present in template php files.
$routes->get('idfit_connexion.php', 'Home::connexion');
$routes->get('idfit_inscription_identite.php', 'Home::inscriptionIdentite');
$routes->get('inscription_etape2.php', 'Home::inscriptionSante');
$routes->get('idfit_inscription_sante.php', 'Home::inscriptionSante');
$routes->get('idfit_dashboard_user.php', 'Home::dashboardUser');
$routes->get('idfit_regimes.php', 'Home::regimes');
$routes->get('idfit_finance.php', 'Home::finance');
$routes->get('idfit_admin.php', 'Home::adminPreview');

// Routes utilisateur connecte
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->post('wallet/recharge', 'WalletController::recharge');
    $routes->post('gold/upgrade', 'GoldController::upgrade');
    $routes->post('subscription/subscribe', 'SubscriptionController::subscribe');
});

// Routes admin
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'AdminController::index');

    $routes->get('regimes', 'RegimeController::index');
    $routes->post('regimes', 'RegimeController::create');
    $routes->post('regimes/(:num)/delete', 'RegimeController::delete/$1');

    $routes->get('sports', 'SportController::index');
    $routes->post('sports', 'SportController::create');
    $routes->post('sports/(:num)/delete', 'SportController::delete/$1');

    $routes->post('prix-regimes', 'PrixRegimeController::create');
    $routes->post('prix-regimes/(:num)/delete', 'PrixRegimeController::delete/$1');
});


/**
 * @var RouteCollection $routes
 */
$routes->group('api', static function ($routes) {
    // Routes publiques
    $routes->post('register', 'Api\AuthController::register');
    $routes->post('login', 'Api\AuthController::login');
    
    // Routes privées (protégées par le middleware 'auth')
    $routes->group('', ['filter' => 'auth'], static function ($routes) {
        $routes->get('logout', 'Api\AuthController::logout');
        
        // Profil & Dashboard
        $routes->get('profile', 'Api\DashboardController::profile');
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
