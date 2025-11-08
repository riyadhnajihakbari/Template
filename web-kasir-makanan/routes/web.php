<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // POS
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::get('/api/menu', [POSController::class, 'getMenu']);
    Route::post('/api/orders', [POSController::class, 'createOrder']);
    Route::post('/api/sync/offline-transactions', [POSController::class, 'syncOfflineTransactions']);
    
    // Menu Management (Manajer & Admin only)
    Route::middleware('role:manajer,admin')->group(function () {
        Route::resource('menu', MenuController::class);
        Route::post('/menu/{menuItem}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');
    });
    
    // Reports (Manajer & Admin only)
    Route::middleware('role:manajer,admin')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
    });
});

// PWA Manifest
Route::get('/manifest.json', function () {
    return response()->json([
        'name' => 'Web Kasir Makanan',
        'short_name' => 'Kasir',
        'description' => 'Aplikasi POS Offline-First',
        'start_url' => '/dashboard',
        'display' => 'standalone',
        'background_color' => '#ffffff',
        'theme_color' => '#3b82f6',
        'icons' => [
            [
                'src' => '/images/icon-192.png',
                'sizes' => '192x192',
                'type' => 'image/png'
            ],
            [
                'src' => '/images/icon-512.png',
                'sizes' => '512x512',
                'type' => 'image/png'
            ]
        ]
    ]);
});
