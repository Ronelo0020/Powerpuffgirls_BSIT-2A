<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// --- AUTHENTICATION ---
$routes->get('/', 'Auth::index');
$routes->post('auth/loginProcess', 'Auth::loginProcess');
$routes->get('auth/logout', 'Auth::logout');

// --- DASHBOARD ---
$routes->get('dashboard', 'Dashboard::index');

// --- PRODUCT CRUD (Fixed) ---
$routes->get('products', 'Products::index');
$routes->get('products/add', 'Products::add');
$routes->post('products/store', 'Products::store');
$routes->get('products/edit/(:num)', 'Products::edit/$1');
$routes->post('products/update/(:num)', 'Products::update/$1');
$routes->get('products/delete/(:num)', 'Products::delete/$1');

// --- POS & SALES ---
$routes->get('pos', 'Pos::index');
$routes->post('pos/save_order', 'Pos::save_order'); 
$routes->get('sales', 'Sales::index');

// --- MANAGE STAFF (Admin Only) ---
$routes->get('auth/manage', 'Auth::manage');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/store', 'Auth::store');
$routes->get('auth/staff_edit/(:num)', 'Auth::edit/$1');
$routes->post('auth/staff_update/(:num)', 'Auth::update/$1');
$routes->get('auth/staff_delete/(:num)', 'Auth::delete/$1');