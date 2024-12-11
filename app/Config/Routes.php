<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/pages/dashboard', 'DashboardController::dashboardMainPage');
$routes->get('/pages/login', 'LoginController::loginPage');
$routes->get('/', 'LoginController::loginPage');
$routes->post('/pages/login/auth', 'LoginController::authenticate');
$routes->get('/pages/logout', 'LoginController::logout');

// rotas de manipulacao de usuarios
$routes->get('/pages/usuarios', 'UserController::userPage');
$routes->get('/pages/usuarios/all', 'UserController::listarUsuarios');
$routes->post('/pages/usuarios/create', 'UserController::criarNovoUsuario');
$routes->post('/pages/usuarios/delete/(:num)', 'UserController::deletarUsuario/$1');
$routes->put('/pages/usuarios/update/(:num)', 'UserController::atualizarUsuario/$1');
$routes->post('/pages/usuarios/updatePassword', 'UserController::atualizarSenha');