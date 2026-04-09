<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/movements', [StockMovementController::class, 'index'])->name('movements.index');
Route::post('/stock-movements', [StockMovementController::class, 'store'])->name('stock-movements.store');
