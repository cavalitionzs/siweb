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

// JUAL //
$routes->post('/chart-transaksi', 'Home::showChartTransaksi');
$routes->post('/chart-customer', 'Home::showChartCustomer');

// BELI //
$routes->post('/chart-beli', 'Home::showChartBeli');
$routes->post('/chart-supplier', 'Home::showChartSupplier');

// BUKU // 
$routes->group('book', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Book::index', ['filter' => 'auth']);
    $r->get('create', 'Book::create');
    $r->post('create', 'Book::save');
    $r->post('edit/(:any)', 'Book::update/$1');
    $r->get('edit/(:any)', 'Book::edit/$1');
    $r->get('book-detail/(:any)', 'Book::detail/$1');
    $r->delete('delete/(:num)', 'Book::delete/$1');
    $r->post('import', 'Book::importData');
});

// KOMIK //
$routes->group('komik', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Komik::index', ['filter' => 'auth']);
    $r->get('create', 'Komik::create');
    $r->post('create', 'Komik::save');
    $r->post('edit/(:any)', 'Komik::update/$1');
    $r->get('edit/(:any)', 'Komik::edit/$1');
    $r->get('komik-detail/(:any)', 'Komik::detail/$1');
    $r->delete('delete/(:num)', 'Komik::delete/$1');
    $r->post('import', 'Komik::importData');
});

// DATA CUSTOMER //
$routes->get('/customer/index', 'Customer::index', ['filter' => 'role:Manajer'], ['filter' => 'auth']);
$routes->addRedirect('/customer', '/customer/index')
    ->get('/customer/index', 'Customer::index')->setAutoRoute(true);

// DATA SUPPLIER //
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
$routes->group('login', function ($r) {
    $r->get('/', 'Auth::indexlogin');
    $r->post('auth', 'Auth::auth');
    $r->get('register', 'Auth::indexregister');
    $r->post('save', 'Auth::saveRegister');
});

// LOGOUT // 
$routes->get('/logout', 'Auth::logout');

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

// POS //
// JUAL //
$routes->group('jual', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Penjualan::index');
    $r->get('load', 'Penjualan::loadCart');
    $r->post('/', 'Penjualan::addCart');
    $r->get('gettotal', 'Penjualan::getTotal');
    $r->post('update', 'Penjualan::updateCart');
    $r->post('bayar', 'Penjualan::pembayaran');
    $r->get('laporan', 'Penjualan::report');
    $r->post('laporan/filter', 'Penjualan::filter');
    $r->get('invoicepdf/(:any)', 'Penjualan::invoicePDF/$1');
    $r->get('exportpdf', 'Penjualan::exportpdf');
    $r->get('exportexcel', 'Penjualan::exportExcel');
    $r->delete('(:any)', 'Penjualan::deleteCart/$1');
});

// BELI //
$routes->group('beli', ['filter' => 'auth'], function ($r) {
    $r->get('/', 'Pembelian::index');
    $r->get('load', 'Pembelian::loadCart');
    $r->post('/', 'Pembelian::addCart');
    $r->get('gettotal', 'Pembelian::getTotal');
    $r->post('update', 'Pembelian::updateCart');
    $r->post('bayar', 'Pembelian::pembayaran');
    $r->get('laporan', 'Pembelian::report');
    $r->post('laporan/filter', 'Pembelian::filter');
    $r->get('invoicepdf/(:any)', 'Pembelian::invoicePDF/$1');
    $r->get('exportpdf', 'Pembelian::exportpdf');
    $r->get('exportexcel', 'Pembelian::exportExcel');
    $r->delete('(:any)', 'Pembelian::deleteCart/$1');
});
// END POS //

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
