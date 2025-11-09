<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================================================
// PUBLIC ROUTES
// ============================================================================

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (requires auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================================
// PROTECTED ROUTES (Require Authentication)
// ============================================================================

Route::middleware('auth')->group(function () {
    
    // --------------------------------------------------------------------
    // DASHBOARD - Role-based redirect
    // --------------------------------------------------------------------
    Route::get('/dashboard', function() {
        $user = auth()->user();
        
        // Pelanggan redirect ke menu
        if ($user->isPelanggan()) {
            return redirect()->route('customer.menu');
        }
        
        // Staff redirect ke dashboard
        return app(DashboardController::class)->index();
    })->name('dashboard');
    
    // --------------------------------------------------------------------
    // POS ROUTES - Admin, Manajer, Kasir, Koki
    // --------------------------------------------------------------------
    Route::middleware('role:admin,manajer,kasir,koki')->prefix('pos')->name('pos.')->group(function() {
        Route::get('/', [POSController::class, 'index'])->name('index');
    });
    
    // POS API Routes
    Route::middleware('role:admin,manajer,kasir,koki')->prefix('api')->group(function() {
        Route::get('/menu', [POSController::class, 'getMenu']);
        Route::post('/orders', [POSController::class, 'createOrder']);
        Route::post('/sync/offline-transactions', [POSController::class, 'syncOfflineTransactions']);
    });
    
    // --------------------------------------------------------------------
    // MENU MANAGEMENT - Admin & Manajer Only
    // --------------------------------------------------------------------
    Route::middleware('role:admin,manajer')->group(function () {
        // Resource routes untuk CRUD menu
        Route::resource('menu', MenuController::class)->parameters([
            'menu' => 'menuItem'  // Bind {menu} ke MenuItem model
        ]);
        
        // Custom route untuk toggle status
        Route::post('/menu/{menuItem}/toggle-status', [MenuController::class, 'toggleStatus'])
             ->name('menu.toggle-status');
    });
    
    // --------------------------------------------------------------------
    // REPORTS - Admin & Manajer Only
    // --------------------------------------------------------------------
    Route::middleware('role:admin,manajer')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
    });

    // --------------------------------------------------------------------
    // USER MANAGEMENT - Admin Only
    // --------------------------------------------------------------------
    Route::middleware('role:admin')->group(function () {
        // Resource routes untuk CRUD user
        Route::resource('users', UserController::class);
        
        // Custom route untuk toggle status user
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
             ->name('users.toggle-status');
    });

    // --------------------------------------------------------------------
    // CUSTOMER ROUTES - Pelanggan Only
    // --------------------------------------------------------------------
    Route::middleware('role:pelanggan')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/menu', [CustomerController::class, 'menu'])->name('menu');
    });
});

// ============================================================================
// PWA ROUTES
// ============================================================================

// PWA Manifest
Route::get('/manifest.json', function () {
    return response()->json([
        'name' => 'Web Kasir Makanan',
        'short_name' => 'Kasir',
        'description' => 'Aplikasi POS Offline-First untuk Restoran',
        'start_url' => '/dashboard',
        'display' => 'standalone',
        'background_color' => '#ffffff',
        'theme_color' => '#FF6B35',
        'orientation' => 'portrait',
        'categories' => ['food', 'business'],
        'icons' => [
            [
                'src' => '/images/icon-192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/images/icon-512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ]
        ],
        'screenshots' => [
            [
                'src' => '/images/screenshot1.png',
                'sizes' => '540x720',
                'type' => 'image/png'
            ]
        ]
    ]);
})->name('manifest');

// ============================================================================
// FALLBACK ROUTE (Optional - untuk handle 404)
// ============================================================================

// Route::fallback(function () {
//     return response()->view('errors.404', [], 404);
// });