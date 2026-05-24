<?php

use CodeIgniter\Router\RouteCollection;

// CONTROLADOR DE INICIO - MENU PRINCIIPAL
$routes->get('/', 'Inicio::index');

/** @var RouteCollection $routes */
//$routes->get('/', 'Home::index');

// VERIFICAR CONEXIÓN A LA BASE DE DATOS
$routes->get('/testdb', 'TestDB::index');

// RUTA DE VEHICULOS
