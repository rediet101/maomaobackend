<?php

use App\Http\Controllers\AppUserDashboardController;
use App\Http\Controllers\ContactDashboardController;
use App\Http\Controllers\CustomOrderDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MenuOrderDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/orders/{order}', [DashboardController::class, 'show'])->name('orders.show');
    Route::post('/dashboard/orders/{order}/status', [DashboardController::class, 'updateStatus'])->name('orders.update-status');

    Route::get('/custom-orders', [CustomOrderDashboardController::class, 'index'])->name('custom-orders.index');
    Route::get('/custom-orders/{order}', [CustomOrderDashboardController::class, 'show'])->name('custom-orders.show');
    Route::post('/custom-orders/{order}/status', [CustomOrderDashboardController::class, 'updateStatus'])->name('custom-orders.update-status');

    Route::resource('menu', MenuItemController::class)->except(['show'])->parameters(['menu' => 'menuItem']);

    Route::get('/menu-orders', [MenuOrderDashboardController::class, 'index'])->name('menu-orders.index');
    Route::get('/menu-orders/{menuOrder}', [MenuOrderDashboardController::class, 'show'])->name('menu-orders.show');
    Route::post('/menu-orders/{menuOrder}/status', [MenuOrderDashboardController::class, 'updateStatus'])->name('menu-orders.update-status');

    Route::get('/contact', [ContactDashboardController::class, 'index'])->name('contact.index');
    Route::get('/contact/{contactMessage}', [ContactDashboardController::class, 'show'])->name('contact.show');
    Route::delete('/contact/{contactMessage}', [ContactDashboardController::class, 'destroy'])->name('contact.destroy');

    Route::get('/app-users', [AppUserDashboardController::class, 'index'])->name('app-users.index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
