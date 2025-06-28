<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('pages.auth.login');
});



Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');
    Route::resource('user', UserController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/print', [OrderController::class, 'print'])->name('orders.print');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
});
