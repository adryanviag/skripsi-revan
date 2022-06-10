<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// handling users
$routes->get('/registeradmin', 'Login::register', ['filter' => 'login']);
$routes->post('/register/daftar', 'Login::daftar', ['filter' => 'login']);
$routes->get('/login', 'Login::index', ['filter' => 'login']);
$routes->get('/logout', 'Login::logout', ['filter' => 'auth']);

# master tables
// Handling Data Bibit Ayam
$routes->get('/data-ayam', 'DataBibitAyam::index', ['filter' => 'auth']);
$routes->get('/data-ayam/tambah', 'DataBibitAyam::tambah', ['filter' => 'auth']);
$routes->post('/data-ayam/tambah', 'DataBibitAyam::store', ['filter' => 'auth']);
$routes->get('/data-ayam/hapus/(:segment)', 'DataBibitAyam::delete/$1', ['filter' => 'auth']);
$routes->post('/data-ayam/edit/(:segment)', 'DataBibitAyam::update/$1', ['filter' => 'auth']);
$routes->get('/data-ayam/edit/(:segment)', 'DataBibitAyam::edit/$1', ['filter' => 'auth']);

// Handling Data Bibit Terjual
$routes->get('/penjualan', 'Penjualan::index', ['filter' => 'auth']);
$routes->get('/penjualan/tambah', 'Penjualan::tambah', ['filter' => 'auth']);
$routes->post('/penjualan/tambah', 'Penjualan::store', ['filter' => 'auth']);
$routes->get('/penjualan/hapus/(:segment)', 'Penjualan::delete/$1', ['filter' => 'auth']);
$routes->post('/penjualan/edit/(:segment)', 'Penjualan::update/$1', ['filter' => 'auth']);
$routes->get('/penjualan/edit/(:segment)', 'Penjualan::edit/$1', ['filter' => 'auth']);

// Prediksi
$routes->get('/prediksi', 'Prediksi::index', ['filter' => 'auth']);
$routes->post('/prediksi/lihat', 'Prediksi::lihat', ['filter' => 'auth']);
$routes->post('/prediksi/hitung', 'Prediksi::hitung', ['filter' => 'auth']);
$routes->post('/grafik', 'Prediksi::show_grafik', ['filter' => 'auth']);
$routes->get('/grafik', 'Prediksi::index_grafik', ['filter' => 'auth']);

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
