<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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
    Route::post('/register', 'register')->name('api.auth.register');
    Route::post('/login', 'login')->name('api.auth.login');
});

Route::middleware('auth:api')->controller(AuthController::class)->group(function () {
    Route::get('/profile', 'profile')->name('api.auth.profile');
    Route::post('/logout', 'logout')->name('api.auth.logout');
    Route::get('/refresh', 'refresh')->name('api.auth.refresh');
});

Route::middleware('auth:api')->controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('api.user.list');
    Route::get('/users/{model}', 'detail')->name('api.user.detail');
    Route::post('/users', 'create')->name('api.user.create');
    Route::put('/users/{model}', 'update')->name('api.user.update');
    Route::delete('/users/{model}', 'destroy')->name('api.user.delete');
});

Route::middleware('auth:api')->controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('api.category.list');
    Route::get('/categories/{category}', 'detail')->name('api.category.detail');
    Route::post('/categories', 'create')->name('api.category.create');
    Route::put('/categories/{category}', 'update')->name('api.category.update');
    Route::delete('/categories/{category}', 'destroy')->name('api.category.delete');
});
