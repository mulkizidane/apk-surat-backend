<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Route tes, bisa dihapus jika sudah tidak perlu
$routes->get('/tes', function() {
    return response()->setJSON(['message' => 'Tes route berhasil!']);
});

/*
 * --------------------------------------------------------------------
 * API Routes
 * --------------------------------------------------------------------
 */

// Route ini PUBLIK, tidak perlu token/filter
$routes->post('api/login', 'AuthController::login');

// Grup ini berisi SEMUA route yang butuh token/login (dilindungi filter 'jwt')
$routes->group('api', ['filter' => 'jwt'], static function ($routes) {
    // Auth
    $routes->get('profile', 'AuthController::profile');

    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');

    // Verifikasi
    $routes->put('verifikasi/(:num)', 'VerifikasiController::update/$1');

    // Surat Keluar
    $routes->resource('surat-keluar', ['controller' => 'SuratKeluarController']);

    // Surat Masuk
    $routes->resource('surat-masuk', ['controller' => 'SuratMasukController']);

    //Aproves User
    $routes->get('approvers', 'UserController::getApprovers');

    // Disposisi (sebagai sub-resource dari surat-masuk)
    $routes->post('surat-masuk/(:num)/disposisi', 'DisposisiController::create/$1');
    $routes->get('kategori-surat', 'KategoriSuratController::index');
    $routes->get('jenis-surat', 'JenisSuratController::index');
    $routes->get('units/tree', 'UnitController::getUnitUserTree');
    
    $routes->group('admin', static function ($routes) {
        // Rute untuk mengelola data Users (CRUD)
        $routes->resource('users', ['controller' => 'UserController']);
        // Rute untuk mengelola data Units (CRUD)
        $routes->resource('units', ['controller' => 'UnitController']);
        // Rute untuk mengelola data Roles (CRUD)
        // Anda perlu membuat RoleController jika ingin menggunakan ini.
        // $routes->resource('roles', ['controller' => 'RoleController']);
    });
    
});