<?php

use CodeIgniter\Router\RouteCollection;

/* @var RouteCollection $routes */

// 1. Rutas Generales / Vistas Comunes
$routes->get('/', 'InicioController::index');
$routes->get('testdb', 'TestDBController::index');

// 2. Rutas del Cliente
$routes->get('cliente/vehiculo/(:num)', 'VehiculosController::detalle/$1');
$routes->get('cliente/reservar/(:num)', 'ClientesController::solicitarReserva/$1');
$routes->post('cliente/reservar/procesar', 'ClientesController::procesarReserva');
$routes->get('cliente/resumen', 'ClientesController::resumenReserva');
$routes->post('cliente/reservas/confirmar', 'ClientesController::confirmarReserva');

// 3. Rutas del Administrador

// Clientes
$routes->get('usuarios', 'UsuariosController::index');
$routes->get('usuarios/crear', 'UsuariosController::crear');
$routes->post('usuarios/guardar', 'UsuariosController::guardar');
$routes->get('usuarios/editar/(:num)', 'UsuariosController::editar/$1');
$routes->post('usuarios/actualizar/(:num)', 'UsuariosController::actualizar/$1');
$routes->get('usuarios/eliminar/(:num)', 'UsuariosController::eliminar/$1');

// Vehículos
$routes->get('vehiculos', 'VehiculosController::index');
$routes->get('vehiculos/new', 'VehiculosController::new');
$routes->post('vehiculos/create', 'VehiculosController::create');
$routes->get('vehiculos/edit/(:num)', 'VehiculosController::edit/$1');
$routes->post('vehiculos/update/(:num)', 'VehiculosController::update/$1');
$routes->get('vehiculos/delete/(:num)', 'VehiculosController::delete/$1');
$routes->get('vehiculos/(:num)', 'VehiculosController::show/$1');

// Login y Sesión
$routes->get('login', 'LoginController::index');
$routes->post('login/validar', 'LoginController::validar');
$routes->get('logout', 'LoginController::logout');

// Alquileres
$routes->get(
    'mis-alquileres/resumen/(:num)',
    'Alquileres::verResumen/$1'
);
$routes->get('mis-alquileres', 'Alquileres::mostrarAlquileres');
//$routes->get('mis-alquileres/resumen/(:num)', 'Alquileres::verResumen/$1');

// Alquileres y Devoluciones
// $routes->get('admin/alquileres', 'AlquileresController::index');
// $routes->post('admin/alquileres/aprobar/(:num)', 'AlquileresController::aprobar/$1');
// $routes->post('admin/alquileres/devolucion/(:num)', 'AlquileresController::registrarDevolucion/$1');