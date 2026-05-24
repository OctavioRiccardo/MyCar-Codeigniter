<?php

use CodeIgniter\Router\RouteCollection;

// CONTROLADOR DE INICIO - MENU PRINCIIPAL
$routes->get('/', 'Inicio::index');

/* @var RouteCollection $routes */
//$routes->get('/', 'Home::index');

// VERIFICAR CONEXIÓN A LA BASE DE DATOS
$routes->get('/testdb', 'TestDB::index');

/*
|--------------------------------------------------------------------------
| RUTAS USUARIOS
|--------------------------------------------------------------------------
*/
// LISTADO DE USUARIOS
$routes->get('usuarios', 'UsuariosController::index');
// FORMULARIO DE REGISTRO
$routes->get('usuarios/crear', 'UsuariosController::crear');
// GUARDAR NUEVO USUARIO
$routes->post('usuarios/guardar', 'UsuariosController::guardar');
// FORMULARIO DE EDICIÓN
$routes->get('usuarios/editar/(:num)', 'UsuariosController::editar/$1');
// ACTUALIZAR USUARIO
$routes->post('usuarios/actualizar/(:num)', 'UsuariosController::actualizar/$1');
// ELIMINAR USUARIO
$routes->get('usuarios/eliminar/(:num)', 'UsuariosController::eliminar/$1');