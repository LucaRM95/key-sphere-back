<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;

/*PROPERTY ROUTES*/

Route::get('/properties', [PropertyController::class, 'get_properties']);

/*AUTH ROUTES*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/property', [PropertyController::class, 'create_property']);
    Route::get('/property/{id}', [PropertyController::class, 'get_property']);
    Route::put('/property/{id}', [PropertyController::class, 'update_property']);
    Route::put('/property-availability/{id}', [PropertyController::class, 'property_availability']);
});
