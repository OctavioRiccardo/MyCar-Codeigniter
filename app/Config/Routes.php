<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// VERIFICAR CONEXIÓN A LA BASE DE DATOS
$routes->get('/testdb', 'TestDB::index');