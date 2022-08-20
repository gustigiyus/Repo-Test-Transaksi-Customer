<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Transaksi');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Transaksi::index');
$routes->get('transaksi', 'Transaksi::index');

// Method PHP AJAX
$routes->get('transaksi/add', 'Transaksi::add');
$routes->post('transaksi/add', 'Transaksi::add');
$routes->post('transaksi/prosesAdd', 'Transaksi::prosesAdd');
$routes->post('transaksi/dataBarang3', 'Transaksi::dataBarang3');
$routes->post('transaksi/prosesTransCustomer', 'Transaksi::prosesTransCustomer');

// Route Delete
$routes->delete('transaksi/delete/(:num)', 'Transaksi::delete/$1');

// Route Edit Data Barang
$routes->post('transaksi/editBarang', 'Transaksi::editBarang');
$routes->get('transaksi/editBarang', 'Transaksi::editBarang');
$routes->post('transaksi/prosesUpdateBarang/(:num)', 'Transaksi::prosesUpdateBarang/$1');



// Route get master data customer ajax 
$routes->get('transaksi/get_data_cust', 'Transaksi::get_data_cust');
$routes->post('transaksi/get_data_cust', 'Transaksi::get_data_cust');

// Route get master data barang ajax 
$routes->get('transaksi/get_data_barang', 'Transaksi::get_data_barang');
$routes->post('transaksi/get_data_barang', 'Transaksi::get_data_barang');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
