<?php

use CodeIgniter\Router\RouteCollection;

/* @var RouteCollection $routes */

// ==========================================================================
// 1. VISTAS COMUNES / PÚBLICAS
// ==========================================================================
$routes->get('/', 'InicioController::index');
$routes->get('testdb', 'TestDBController::index');

// Autenticación y Registro de Clientes
$routes->get('login', 'LoginController::index');
$routes->post('login/validar', 'LoginController::validar');
$routes->get('logout', 'LoginController::logout');
$routes->get('usuarios/crear', 'UsuariosController::crear');
$routes->post('usuarios/guardar', 'UsuariosController::guardar');


// ==========================================================================
// 2. RUTAS DEL USUARIO CLIENTE (Rol: cliente)
// ==========================================================================
$routes->get('perfil', 'ClientesController::perfil');
$routes->get('mis-alquileres', 'AlquileresController::mostrarAlquileres');
$routes->get('mis-alquileres/resumen/(:num)', 'AlquileresController::verResumen/$1');
// Proceso de Reserva de Vehículo
$routes->get('cliente/vehiculo/(:num)', 'VehiculosController::detalle/$1');
$routes->get('cliente/reservar/(:num)', 'ClientesController::solicitarReserva/$1');
$routes->post('cliente/reservar/procesar', 'ClientesController::procesarReserva');
$routes->get('cliente/resumen', 'ClientesController::resumenReserva');
$routes->post('cliente/reservas/confirmar', 'ClientesController::confirmarReserva');


// ==========================================================================
// 3. RUTAS DEL ADMINISTRADOR (Rol: administrador)
// ==========================================================================
$routes->get('administrador', 'AdministradorController::index');
$routes->get('administrador/alquileres', 'AlquileresController::listarAlquileresAdmin');
// Gestión de Clientes
$routes->get('usuarios', 'UsuariosController::index');
$routes->get('usuarios/editar/(:num)', 'UsuariosController::editar/$1');
$routes->post('usuarios/actualizar/(:num)', 'UsuariosController::actualizar/$1');
$routes->get('usuarios/eliminar/(:num)', 'UsuariosController::eliminar/$1');
// Gestión de Vehículos 
$routes->get('vehiculos', 'VehiculosController::index');
$routes->get('vehiculos/new', 'VehiculosController::new');
$routes->post('vehiculos/create', 'VehiculosController::create');
$routes->get('vehiculos/edit/(:num)', 'VehiculosController::edit/$1');
$routes->post('vehiculos/update/(:num)', 'VehiculosController::update/$1');
$routes->get('vehiculos/delete/(:num)', 'VehiculosController::delete/$1');
$routes->get('vehiculos/(:num)', 'VehiculosController::show/$1');

//$routes->get('mis-alquileres/resumen/(:num)', 'AlquileresController::verResumen/$1');
// Alquileres y Devoluciones
// $routes->get('admin/alquileres', 'AlquileresController::index');
// $routes->post('admin/alquileres/aprobar/(:num)', 'AlquileresController::aprobar/$1');
// $routes->post('admin/alquileres/devolucion/(:num)', 'AlquileresController::registrarDevolucion/$1');