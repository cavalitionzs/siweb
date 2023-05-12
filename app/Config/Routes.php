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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/book', 'Book::index', ['filter' => 'auth']);
$routes->get('/book/create', 'Book::create');
$routes->post('/book/create', 'Book::save');
$routes->post('/book/edit/(:any)', 'Book::update/$1');
$routes->get('/book/edit/(:any)', 'Book::edit/$1');
$routes->get('/book-detail/(:any)', 'Book::detail/$1');
$routes->delete('/book/(:num)', 'Book::delete/$1');

$routes->get('/komik', 'Komik::index', ['filter' => 'auth']);
$routes->get('/komik/create', 'Komik::create');
$routes->post('/komik/create', 'Komik::save');
$routes->post('/komik/edit/(:any)', 'Komik::update/$1');
$routes->get('/komik/edit/(:any)', 'Komik::edit/$1');
$routes->get('/komik-detail/(:any)', 'Komik::detail/$1');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');

// customer //
$routes->get('/customer/index', 'Customer::index', ['filter' => 'role:Manajer'], ['filter' => 'auth']);
$routes->addRedirect('/customer', '/customer/index')
    ->get('/customer/index', 'Customer::index')->setAutoRoute(true);

// supplier //
$routes->get('/supplier/index', 'Supplier::index', ['filter' => 'role:Manajer'], ['filter' => 'auth']);
$routes->addRedirect('/supplier', '/supplier/index')
    ->get('/supplier/index', 'Supplier::index')->setAutoRoute(true);

// DATA MAHASISWA //
$routes->get('/mahasiswa/index', 'Mahasiswa::index', ['filter' => 'auth']);
$routes->addRedirect('/mahasiswa', '/mahasiswa/index')
    ->get('/mahasiswa/index', 'Mahasiswa::index')->setAutoRoute(true);

// HOME //
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/page', 'Home::page');

// LOGIN //
$routes->get('/login', 'Auth::indexlogin');
$routes->post('/login/auth', 'Auth::auth');
$routes->get('/logout', 'Auth::logout');
$routes->get('/login/register', 'Auth::indexregister');
$routes->post('/login/save', 'Auth::saveRegister');

// DATA USERS //
$routes->group('users', ['filter' => 'role:Owner'], ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Users::index');
    $r->get('index', 'Users::index');
    $r->get('create', 'Users::create');
    $r->post('create', 'Users::save');
    $r->get('edit/(:num)', 'Users::edit/$1');
    $r->post('edit/(:num)', 'Users::update/$1');
    $r->delete('(:num)', 'Users::delete/$1');
});

// POS
$routes->group('jual', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Penjualan::index');
    $r->get('load', 'Penjualan::loadCart');
    $r->post('/', 'Penjualan::addCart');
    $r->get('gettotal', 'Penjualan::getTotal');
    $r->post('update', 'Penjualan::updateCart');
    $r->post('bayar', 'Penjualan::pembayaran');
    $r->delete('(:any)', 'Penjualan::deleteCart/$1');
});

$routes->group('beli', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Pembelian::index');
    $r->get('load', 'Pembelian::loadCart');
    $r->post('/', 'Pembelian::addCart');
    $r->get('gettotal', 'Pembelian::getTotal');
});

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
