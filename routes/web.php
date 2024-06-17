<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Pages\HomeController;
use App\Http\Controllers\Web\Plisio\CallbackController;
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

/**
 * Admin panel
 */
Route::view('/admin/{any?}', 'admin-panel')
    ->where('any', '.*')
    ->name('admin-panel');

Route::post('/admin/login', LoginController::class)
    ->middleware(['throttle:5,1',])
    ->name('admin-panel.login');
Route::post('/admin/logout', LogoutController::class)
    ->middleware(['auth:admin',])
    ->name('admin-panel.logout');

/**
 * Auth
 */
Route::post('/register', RegisterController::class);

/**
 * Plisio
 */
Route::post('/plisio/callback', CallbackController::class);

/**
 * Pages
 */
Route::get('/', HomeController::class)->name('pages.home');
