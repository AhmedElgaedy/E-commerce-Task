<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('update-password', [UserController::class, 'updatePassword']);
    Route::post('logout', [UserController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);

    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
});

Route::get('products', [ProductController::class, 'index']);


