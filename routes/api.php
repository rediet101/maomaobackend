<?php

use App\Http\Controllers\Api\AppUserController;
use App\Http\Controllers\Api\CakeOrderController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\MenuOrderController;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/orders', [CakeOrderController::class, 'index']);
Route::post('/orders', [CakeOrderController::class, 'store']);
Route::post('/orders/{id}/complete', [CakeOrderController::class, 'completeOrder']);
Route::post('/orders/{id}/feedback', [CakeOrderController::class, 'submitFeedback']);
Route::get('/menu', [MenuItemController::class, 'index']);
Route::post('/menu-orders', [MenuOrderController::class, 'store']);
Route::post('/contact', [ContactMessageController::class, 'store']);
Route::post('/users', [AppUserController::class, 'store']);
Route::post('/users/{appUser}', [AppUserController::class, 'update']);
Route::get('/notifications', [NotificationController::class, 'index']);
