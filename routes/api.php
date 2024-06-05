<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

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
    Route::get('/users/total', 'total_user')->name('api.user.total');
    Route::get('/users/{model}', 'detail')->name('api.user.detail');
    Route::post('/users', 'create')->name('api.user.create');
    Route::put('/users/{model}', 'update')->name('api.user.update');
    Route::delete('/users/{model}', 'destroy')->name('api.user.delete');
    Route::get('/user/subordinate', 'get_subordinate')->name('api.user.subordinate');
});

Route::middleware('auth:api')->controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('api.category.list');
    Route::get('/categories/total', 'total_category')->name('api.category.total');
    Route::get('/categories/{category}', 'detail')->name('api.category.detail');
    Route::post('/categories', 'create')->name('api.category.create');
    Route::put('/categories/{category}', 'update')->name('api.category.update');
    Route::delete('/categories/{category}', 'destroy')->name('api.category.delete');
});

Route::middleware('auth:api')->controller(CommentController::class)->group(function () {
    Route::get('task/comment/{task}', 'index')->name('api.comment.list');
    Route::post('task/comment/{task}', 'store')->name('api.comment.create');
    Route::put('task/comment/{comment}', 'update')->name('api.comment.update');
    Route::delete('task/comment/{comment}', 'destroy')->name('api.comment.delete');
});

Route::middleware('auth:api')->controller(TaskController::class)->group(function () {
    Route::get('/tasks', 'index')->name('api.task.list');
    Route::get('/tasks/summary', 'summary')->name('api.task.summary');
    Route::get('/tasks/total', 'total_task_status')->name('api.task.total');
    Route::get('/tasks/{model}', 'detail')->name('api.task.detail');
    Route::post('/tasks', 'create')->name('api.task.create');
    Route::put('/tasks/{model}', 'update')->name('api.task.update');
    Route::delete('/tasks/{model}', 'destroy')->name('api.task.delete');
    Route::delete('/tasks/{model}/delete-file', 'deleteFile')->name('api.task.delete-file');
});

// create total user api per team
Route::middleware('auth:api')->controller(UserController::class)->group(function () {
});
