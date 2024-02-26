<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register', 'register')->name('api.auth.register');
    Route::post('/auth/login', 'login')->name('api.auth.login');
});

Route::middleware('auth:api')->controller(AuthController::class)->group(function() {
    Route::get('/auth/profile', 'profile')->name('api.auth.profile');
    Route::post('/auth/logout', 'logout')->name('api.auth.logout');
    Route::get('/auth/refresh', 'refresh')->name('api.auth.refresh');
});
