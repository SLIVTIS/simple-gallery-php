<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register', 'RegisterController::register');

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('usuarios', 'AdminController::usuarios');
    $routes->get('reportes', 'AdminController::reportes');

    $routes->get('gallery/(:num)', 'ImageController::viewGallery/$1');

    //Rutas de usuario
    //Vistas
    $routes->get('user', 'UserController::index');
    $routes->get('user/create', 'UserController::viewCreate');
    $routes->get('user/edit/(:num)', 'UserController::viewEdit/$1');
    $routes->get('user/changepass/(:num)', 'UserController::viewChangePass/$1');
    //api
    $routes->post('user/store', 'UserController::store');
    $routes->post('user/update/(:num)', 'UserController::update/$1');
    $routes->get('user/delete/(:num)', 'UserController::delete/$1');
    $routes->put('user/changepass/(:num)', 'UserController::updatePass/$1');
});

$routes->group('', ['filter' => 'auth:user'], function($routes){
    //Rutas del controllador de imagenes
    $routes->get('/', 'ImageController::index');
    $routes->get('/image/(:any)', 'ImageController::serveImage/$1');//sirve solo una imagen
    $routes->post('/image', 'ImageController::create');
    $routes->put('/image/(:num)', 'ImageController::update/$1');
    $routes->delete('/image/(:num)', 'ImageController::delete/$1');  
    $routes->delete('image/delete-selected', 'ImageController::deleteSelected');

    $routes->get('/logout', 'LoginController::logout');
});

