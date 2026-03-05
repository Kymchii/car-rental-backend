<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('invoices', [InvoiceController::class, 'index']);
    Route::post('client', [ClientController::class, 'store']);
    Route::get('client', [ClientController::class, 'index']);
    Route::put('client', [ClientController::class, 'update']);
    Route::post('checkout', [CheckoutController::class, 'store']);
    Route::put('checkout/{invoice}', [CheckoutController::class, 'update']);
    Route::post('midtrans/notification', [CheckoutController::class, 'notification']);
});

Route::get('/car-brands', [CarBrandController::class, 'index']);
Route::get('/car-models', [CarTypeController::class, 'index']);