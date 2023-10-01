<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/auth/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['login'])->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/routes', [RouteController::class, 'index'])->name('routes.index');
    Route::post('/routes', [RouteController::class, 'store'])->name('routes.store');

    Route::get('/list/routes/{id}', [RouteController::class, 'listRoutes'])->name('list.routes.index');
    Route::post('/list/routes', [RouteController::class, 'storeListRoutes'])->name('list.routes.store');
    Route::delete('/list/routes/{id}', [RouteController::class, 'destroyListRoutes'])->name('list.routes.destroy');

    Route::get('/map/{id}', [RouteController::class, 'map'])->name('map.index');
});
