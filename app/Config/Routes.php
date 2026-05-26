<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

// Auth routes
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');

// Dashboard route (Auth only)
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Pegawai routes (CRUD - Admin only)
$routes->group('pegawai', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Pegawai::index');
    $routes->get('create', 'Pegawai::create');
    $routes->post('store', 'Pegawai::store');
    $routes->get('edit/(:num)', 'Pegawai::edit/$1');
    $routes->post('update/(:num)', 'Pegawai::update/$1');
    $routes->get('delete/(:num)', 'Pegawai::delete/$1');
});

// Pejabat routes (CRUD - Admin only)
$routes->group('pejabat', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Pejabat::index');
    $routes->get('create', 'Pejabat::create');
    $routes->post('store', 'Pejabat::store');
    $routes->get('edit/(:num)', 'Pejabat::edit/$1');
    $routes->post('update/(:num)', 'Pejabat::update/$1');
    $routes->get('delete/(:num)', 'Pejabat::delete/$1');
});

// Biaya routes (CRUD - Admin only)
$routes->group('biaya', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Biaya::index');
    $routes->get('create', 'Biaya::create');
    $routes->post('store', 'Biaya::store');
    $routes->get('edit/(:num)', 'Biaya::edit/$1');
    $routes->post('update/(:num)', 'Biaya::update/$1');
    $routes->get('delete/(:num)', 'Biaya::delete/$1');
});

// User routes (CRUD - Admin only)
$routes->group('user', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('create', 'User::create');
    $routes->post('store', 'User::store');
    $routes->get('edit/(:num)', 'User::edit/$1');
    $routes->post('update/(:num)', 'User::update/$1');
    $routes->get('delete/(:num)', 'User::delete/$1');
});

// Surat Tugas routes (CRUD - Auth only)
$routes->group('surat-tugas', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SuratTugas::index');
    $routes->get('create', 'SuratTugas::create');
    $routes->post('store', 'SuratTugas::store');
    $routes->get('print/(:num)', 'SuratTugas::print/$1');
    $routes->get('edit/(:num)', 'SuratTugas::edit/$1');
    $routes->post('update/(:num)', 'SuratTugas::update/$1');
    $routes->get('delete/(:num)', 'SuratTugas::delete/$1');
});

// Alias group for underscore compatibility
$routes->group('surat_tugas', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SuratTugas::index');
    $routes->get('create', 'SuratTugas::create');
    $routes->post('store', 'SuratTugas::store');
    $routes->get('print/(:num)', 'SuratTugas::print/$1');
    $routes->get('edit/(:num)', 'SuratTugas::edit/$1');
    $routes->post('update/(:num)', 'SuratTugas::update/$1');
    $routes->get('delete/(:num)', 'SuratTugas::delete/$1');
});

// SPPD routes (Auth only)
$routes->group('sppd', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Sppd::index');
    $routes->get('create/(:num)', 'Sppd::create/$1');
    $routes->get('print/(:num)', 'Sppd::print/$1');
    $routes->get('kwitansi/(:num)', 'Sppd::kwitansi/$1');
    $routes->get('delete/(:num)', 'Sppd::delete/$1');
});
