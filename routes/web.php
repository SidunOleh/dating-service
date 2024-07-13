<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Web\Images\UploadController;
use App\Http\Controllers\Web\Ads\ClickController;
use App\Http\Controllers\Web\Auth\SignInResendCodeController;
use App\Http\Controllers\Web\Auth\SignInSendCodeController;
use App\Http\Controllers\Web\Auth\SignInVerifyCodeController;
use App\Http\Controllers\Web\Auth\SignUpResendCodeController;
use App\Http\Controllers\Web\Auth\SignUpSendCodeController;
use App\Http\Controllers\Web\Auth\SignUpVerifyCodeController;
use App\Http\Controllers\Web\Favorites\AddToFavotiresController;
use App\Http\Controllers\Web\Favorites\RemoveFromFavotiresController;
use App\Http\Controllers\Web\Pages\HomeController;
use App\Http\Controllers\Web\Pages\ProfileController;
use App\Http\Controllers\Web\Password\ForgotController;
use App\Http\Controllers\Web\Password\ResetController;
use App\Http\Controllers\Web\Password\ResetPageController;
use App\Http\Controllers\Web\Plisio\CallbackController;
use App\Http\Controllers\Web\Profile\CreateController;
use App\Http\Controllers\Web\Profile\EditController;
use App\Http\Controllers\Web\Profile\ShowController;
use App\Http\Controllers\Web\Profile\StoreController;
use App\Http\Controllers\Web\Profile\SwitchOptionController;
use App\Http\Controllers\Web\Profile\UpdateController;
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
 * Sing up
 */
Route::post('/sign-up/send-code', SignUpSendCodeController::class)
    ->middleware(['throttle:5,1',])
    ->name('sign-up.send-code');
Route::post('/sign-up/verify-code', SignUpVerifyCodeController::class)
    ->name('sign-up.verify-code');
Route::post('/sign-up/resend-code', SignUpResendCodeController::class)
    ->name('sign-up.resend-code');

/**
 * Sing in
 */
Route::post('/sign-in/send-code', SignInSendCodeController::class)
    ->middleware(['throttle:5,1',])
    ->name('sign-in.send-code');
Route::post('/sign-in/verify-code', SignInVerifyCodeController::class)
    ->name('sign-in.verify-code');
Route::post('/sign-in/resend-code', SignInResendCodeController::class)
    ->name('sign-in.resend-code');

/**
 * Password
 */
Route::post('/password/forgot', ForgotController::class)
    ->name('web.password.forgot');
Route::get('/password/reset', ResetPageController::class)
    ->name('web.password.reset.page');
Route::post('/password/reset', ResetController::class)
    ->name('web.password.reset');

/**
 * Plisio
 */
Route::post('/plisio/callback', CallbackController::class);

/**
 * Pages
 */
Route::get('/', HomeController::class)
    ->name('home');
Route::get('/page/{page}', HomeController::class)
    ->name('home.page');
Route::get('/profile/{creator}', ProfileController::class)
    ->middleware(['track.profile-visits',])
    ->name('profile.page');

/**
 * Favorites
 */
Route::prefix('/favorites')
    ->name('favorites.')
    ->middleware(['auth:web',])
    ->group(function () {
    Route::post('add', AddToFavotiresController::class)
        ->name('add');
    Route::post('remove', RemoveFromFavotiresController::class)
        ->name('remove');
});

/**
 * Ads
 */
Route::post('/ads/{ad}/click', ClickController::class);

/**
 * Profile
 */
Route::prefix('/my-profile')
    ->middleware(['auth:web',])
    ->name('my-profile.')
    ->group(function () {
    Route::get('/', ShowController::class)
        ->name('show');
    Route::get('/create', CreateController::class)
        ->name('create');
    Route::post('/', StoreController::class)
        ->name('store');
    Route::get('/edit', EditController::class)
        ->name('edit');
    Route::put('/', UpdateController::class)
        ->name('update');
    Route::patch('/switch-option', SwitchOptionController::class)
        ->name('switch-option');
});

/**
 * Images
 */
Route::prefix('/images')->name('images.')->middleware(['auth:web',])->group(function () {
    Route::post('/upload', UploadController::class)
        ->name('upload');
});
