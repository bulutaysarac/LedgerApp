<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// User routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/balance', [UserController::class, 'showBalance'])->name('balance');
    Route::post('/transfer', [UserController::class, 'transferCredits'])->name('transfer');
});

// Admin routes
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/admin/add-credits', [AdminController::class, 'addCredits'])->name('admin.addCredits');
    Route::get('/admin/balance/{userId}', [AdminController::class, 'viewBalance'])->name('admin.viewBalance');
    Route::get('/admin/all-balances', [AdminController::class, 'getAllBalances'])->name('admin.getAllBalances');
    Route::post('/admin/balance-at-time', [AdminController::class, 'getBalanceAtTime'])->name('admin.getBalanceAtTime');
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
