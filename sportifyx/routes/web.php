<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\EventController as AdminEvent;
use App\Http\Controllers\Admin\NewsController as AdminNews;
use App\Http\Controllers\Admin\MatchController as AdminMatch;
use App\Http\Controllers\Admin\StoreProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\PaymentMethodController as AdminPayment;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/sport/{sport:slug}', [EventController::class, 'bySport'])->name('events.by-sport');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Matches
Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');

// Store - Public
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/product/{product}', [StoreController::class, 'show'])->name('store.show');

// Auth required routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard redirect
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // ========== TICKET ORDERS (NEW FLOW) ==========
    Route::get('/tickets/{event}/{ticket}/checkout', [OrderController::class, 'checkout'])->name('tickets.checkout');
    Route::post('/tickets/{event}/{ticket}/payment', [OrderController::class, 'payment'])->name('tickets.payment');
    Route::post('/tickets/{event}/{ticket}/process', [OrderController::class, 'processOrder'])->name('tickets.process');
    Route::get('/tickets/order/{order}', [OrderController::class, 'orderDetail'])->name('tickets.order.detail');
    Route::get('/my-tickets', [OrderController::class, 'myTickets'])->name('my-tickets.index');

    // ========== STORE ORDERS ==========
    Route::get('/store/product/{product}/checkout', [StoreController::class, 'checkout'])->name('store.checkout');
    Route::post('/store/product/{product}/payment', [StoreController::class, 'payment'])->name('store.payment');
    Route::post('/store/product/{product}/process', [StoreController::class, 'processOrder'])->name('store.process');
    Route::get('/store/order/{order}', [StoreController::class, 'orderDetail'])->name('store.order.detail');
    Route::get('/store-history', [StoreController::class, 'history'])->name('store.history');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('events', AdminEvent::class);
    Route::resource('news', AdminNews::class);
    Route::resource('matches', AdminMatch::class);
    Route::resource('products', AdminProduct::class);
    Route::resource('users', AdminUser::class);
    Route::resource('payment-methods', AdminPayment::class);
    
    Route::get('/orders/tickets', [AdminOrder::class, 'tickets'])->name('orders.tickets');
    Route::get('/orders/store', [AdminOrder::class, 'store'])->name('orders.store');
    Route::patch('/orders/ticket/{order}/status', [AdminOrder::class, 'updateTicketStatus'])->name('orders.ticket.status');
    Route::patch('/orders/store/{order}/status', [AdminOrder::class, 'updateStoreStatus'])->name('orders.store.status');
    Route::get('/scan-ticket', [AdminOrder::class, 'scanPage'])->name('scan.page');
    Route::post('/scan-ticket/verify', [AdminOrder::class, 'verifyTicket'])->name('scan.verify');
});

require __DIR__.'/auth.php';