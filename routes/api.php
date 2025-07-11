<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// === AUTH ===
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// === PROTECTED ROUTES ===
Route::middleware('auth:sanctum')->group(function () {

    // === PRODUCT CRUD ===
    Route::apiResource('/products', ProductController::class);

    // === ORDER CRUD ===
    Route::apiResource('/orders', OrderController::class);

    // === USER CRUD ===
    Route::apiResource('/users', UserController::class);

});
