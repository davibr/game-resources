<?php

use App\Http\Controllers\JogosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Jogos
Route::get('jogos', [JogosController::class, 'index'])
    ->name('jogos')
    ->middleware('auth');

Route::get('jogos/create', [JogosController::class, 'create'])
    ->name('jogos.create')
    ->middleware('auth');

Route::post('jogos', [JogosController::class, 'store'])
    ->name('jogos.store')
    ->middleware('auth');

Route::get('jogos/edit', [JogosController::class, 'edit'])
    ->name('jogos.edit')
    ->middleware('auth');

Route::put('jogos/{jogo}', [JogosController::class, 'update'])
    ->name('jogos.update')
    ->middleware('auth');

Route::delete('jogos/{jogo}', [JogosController::class, 'destroy'])
    ->name('jogos.destroy')
    ->middleware('auth');
