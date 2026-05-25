<?php

use CodeIgniter\Router\RouteCollection;

/* @var RouteCollection $routes */

// 1. Rutas Generales / Vistas Comunes
$routes->get('/', 'Inicio::index');
$routes->get('testdb', 'TestDB::index');

// 2. Rutas del Cliente
// $routes->get('cliente/reservar/(:num)', 'ClientesController::solicitarReserva/$1');
// $routes->post('cliente/reservas/guardar', 'ClientesController::guardarReserva');

// 3. Rutas del Administrador

// Clientes
$routes->get('usuarios', 'UsuariosController::index');
$routes->get('usuarios/crear', 'UsuariosController::crear');
$routes->post('usuarios/guardar', 'UsuariosController::guardar');
$routes->get('usuarios/editar/(:num)', 'UsuariosController::editar/$1');
$routes->post('usuarios/actualizar/(:num)', 'UsuariosController::actualizar/$1');
$routes->get('usuarios/eliminar/(:num)', 'UsuariosController::eliminar/$1');

// Vehículos
$routes->get('vehiculos', 'Vehiculos::index');
$routes->get('vehiculos/new', 'Vehiculos::new');
$routes->post('vehiculos/create', 'Vehiculos::create');
$routes->get('vehiculos/edit/(:num)', 'Vehiculos::edit/$1');
$routes->post('vehiculos/update/(:num)', 'Vehiculos::update/$1');
$routes->get('vehiculos/delete/(:num)', 'Vehiculos::delete/$1');
$routes->get('vehiculos/(:num)', 'Vehiculos::show/$1');

// LOGIN
$routes->get('login', 'Login::index');
$routes->post('login/validar', 'Login::validar');
$routes->get('logout', 'Login::logout');

// Alquileres y Devoluciones
// $routes->get('admin/alquileres', 'AlquileresController::index');
// $routes->post('admin/alquileres/aprobar/(:num)', 'AlquileresController::aprobar/$1');
// $routes->post('admin/alquileres/devolucion/(:num)', 'AlquileresController::registrarDevolucion/$1');