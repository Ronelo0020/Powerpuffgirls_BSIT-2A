<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');

// Person routes

$routes->get('/person', 'person::index');
$routes->post('person/save', 'person::save');
$routes->get('person/edit/(:segment)', 'person::edit/$1');
$routes->post('person/update', 'person::update');
$routes->delete('person/delete/(:num)', 'person::delete/$1');
$routes->post('person/fetchRecords', 'person::fetchRecords');

// Logs routes for admin
$routes->get('/log', 'Logs::log');