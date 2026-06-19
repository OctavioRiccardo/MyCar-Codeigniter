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
$routes->get('usuarios', 'AdministradorController::listarUsuarios');
$routes->get('usuarios/editar/(:num)', 'AdministradorController::editarUsuario/$1');
$routes->post('usuarios/actualizar/(:num)', 'AdministradorController::actualizarUsuario/$1');
$routes->get('usuarios/eliminar/(:num)', 'AdministradorController::eliminarUsuario/$1');
// Gestión de Vehículos 
$routes->get('vehiculos', 'VehiculosController::index');
$routes->get('vehiculos/new', 'VehiculosController::new');
$routes->post('vehiculos/create', 'VehiculosController::create');
$routes->get('vehiculos/edit/(:num)', 'VehiculosController::edit/$1');
$routes->post('vehiculos/update/(:num)', 'VehiculosController::update/$1');
$routes->get('vehiculos/delete/(:num)', 'VehiculosController::delete/$1');
$routes->get('vehiculos/(:num)', 'VehiculosController::show/$1');

// Alquileres y Devoluciones (Admin)
$routes->post('administrador/alquileres/aprobar/(:num)', 'AlquileresController::aprobarReserva/$1');
$routes->post('administrador/alquileres/devolucion/(:num)', 'AlquileresController::devolucionVehiculo/$1');
$routes->get('administrador/alquileres/activos', 'AlquileresController::listarAlquileresActivos');

// Consultas Cruzadas Especiales (Admin)
$routes->get('administrador/vehiculos/clientes/(:num)', 'VehiculosController::mostrarClientes/$1');
$routes->get('administrador/usuarios/vehiculos/(:num)', 'AdministradorController::mostrarVehiculos/$1');