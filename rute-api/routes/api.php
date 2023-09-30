<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GaleryController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/routes', [RouteController::class, 'index']);
    Route::post('/routes', [RouteController::class, 'store']);
    Route::get('/routes/{route}', [RouteController::class, 'show']);
    Route::put('/routes/{route}', [RouteController::class, 'update']);
    Route::delete('/routes/{route}', [RouteController::class, 'destroy']);

    Route::get('/list/routes/{route}', [RouteController::class, 'listRoute']);
    Route::post('/list/routes', [RouteController::class, 'addRoute']);
    Route::delete('/list/routes/{detail}', [RouteController::class, 'destroyRoute']);

    Route::get('/galeries', [GaleryController::class, 'index']);
    Route::post('/galeries', [GaleryController::class, 'store']);
    Route::get('/galeries/{galery}', [GaleryController::class, 'show']);
    Route::delete('/galeries/{galery}', [GaleryController::class, 'destroy']);
});

Route::get('/not-authorized', [AuthController::class, 'notAuthorized'])->name('notAuthorized');
