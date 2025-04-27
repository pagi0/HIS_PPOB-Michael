<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('dashboard', 'HomeController::index');

$routes->get('registrasi', 'RegistrasiController::index');

$routes->get('login', 'LoginController::index');

$routes->get('profile', 'ProfileController::index');
$routes->get('profile_edit', 'ProfileController::edit');

$routes->get('topup', 'TopupController::index');
$routes->get('transaction', 'TransactionController::index');
$routes->get('service/(:segment)', 'ServiceController::index/$1');

$routes->post('mockup_register', 'MockupController::mockup_register');
$routes->post('mockup_login', 'MockupController::mockup_login');
$routes->post('mockup_transaction', 'MockupController::mockup_transaction');
