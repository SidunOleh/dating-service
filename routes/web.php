<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Web\Images\UploadController;
use App\Http\Controllers\Web\Ads\ClickController;
use App\Http\Controllers\Web\Auth\LogOutController as AuthLogOutController;
use App\Http\Controllers\Web\Auth\SignInResendCodeController;
use App\Http\Controllers\Web\Auth\SignInSendCodeController;
use App\Http\Controllers\Web\Auth\SignInVerifyCodeController;
use App\Http\Controllers\Web\Auth\SignUpResendCodeController;
use App\Http\Controllers\Web\Auth\SignUpSendCodeController;
use App\Http\Controllers\Web\Auth\SignUpVerifyCodeController;
use App\Http\Controllers\Web\Favorites\AddToFavotiresController;
use App\Http\Controllers\Web\Favorites\RemoveFromFavotiresController;
use App\Http\Controllers\Web\Images\DeleteController;
use App\Http\Controllers\Web\Pages\EarnController;
use App\Http\Controllers\Web\Pages\FAQController;
use App\Http\Controllers\Web\Pages\FavoritesController;
use App\Http\Controllers\Web\Pages\HomeController;
use App\Http\Controllers\Web\Pages\ProfileController;
use App\Http\Controllers\Web\Pages\SettingsController;
use App\Http\Controllers\Web\Pages\SubscriptionController;
use App\Http\Controllers\Web\Pages\TopVoteController;
use App\Http\Controllers\Web\Password\ForgotController;
use App\Http\Controllers\Web\Password\ResetController;
use App\Http\Controllers\Web\Payments\DepositController;
use App\Http\Controllers\Web\Payments\WithdrawResendController;
use App\Http\Controllers\Web\Payments\WithdrawSendController;
use App\Http\Controllers\Web\Payments\WithdrawVerifyController;
use App\Http\Controllers\Web\Profile\CreateController;
use App\Http\Controllers\Web\Profile\DeleteController as ProfileDeleteController;
use App\Http\Controllers\Web\Profile\EditController;
use App\Http\Controllers\Web\Profile\ShowController;
use App\Http\Controllers\Web\Profile\StoreController;
use App\Http\Controllers\Web\Profile\SwitchOptionController;
use App\Http\Controllers\Web\Profile\UpdateController;
use App\Http\Controllers\Web\Roulette\GetPairController;
use App\Http\Controllers\Web\Roulette\VoteController;
use App\Http\Controllers\Web\Settings\ChangeEmailResendController;
use App\Http\Controllers\Web\Settings\ChangeEmailSendController;
use App\Http\Controllers\Web\Settings\ChangeEmailVerifyController;
use App\Http\Controllers\Web\Settings\ChangePasswordController;
use App\Http\Controllers\Web\Subscription\SubscribeController;
use App\Http\Controllers\Web\Subscription\UnsubscribeController;
use App\Http\Controllers\Web\Webhooks\PlisioCallbackController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

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
Route::view('/v54vc45xc54v5vc56cxv7657/{any?}', 'admin-panel')
    ->where('any', '.*')
    ->name('admin-panel');

Route::post('/v54vc45xc54v5vc56cxv7657/login', LoginController::class)
    ->middleware(['throttle:5,1',])
    ->name('admin-panel.login');
Route::post('/v54vc45xc54v5vc56cxv7657/logout', LogoutController::class)
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
 * Log out
 */
Route::get('/log-out', AuthLogOutController::class)
    ->name('web.logout');

/**
 * Password
 */
Route::post('/password/forgot', ForgotController::class)
    ->name('web.password.forgot');
Route::post('/password/reset', ResetController::class)
    ->name('web.password.reset');

/**
 * Webhooks
 */
Route::post('/plisio/callback', PlisioCallbackController::class);

/**
 * Pages
 */
Route::get('/', HomeController::class)
    ->name('home.index');
Route::get('/page/{page?}', HomeController::class)
    ->where('page', '[0-9]+')
    ->name('home.page');
Route::get('/profile/{creator}', ProfileController::class)
    ->middleware(['track.profile-visits',])
    ->where('page', '[0-9]+')
    ->name('profile.page');
Route::get('/top-vote', TopVoteController::class)
    ->middleware(['auth:web',])
    ->name('top-vote.page');
Route::get('/favorites', FavoritesController::class)
    ->middleware(['auth:web',])
    ->name('favorites.index');
Route::get('/favorites/page/{page}', FavoritesController::class)
    ->middleware(['auth:web',])
    ->name('favorites.page');
Route::get('/subscription', SubscriptionController::class)
    ->middleware(['auth:web',])
    ->name('subscription.page');
Route::get('/earn', EarnController::class)
    ->middleware(['auth:web',])
    ->name('earn.page');
Route::get('/settings', SettingsController::class)
    ->middleware(['auth:web',])
    ->name('settings.page');
Route::get('/faq', FAQController::class)
    ->name('faq.page');

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
    Route::delete('/', ProfileDeleteController::class)
        ->name('delete');
});

/**
 * Images
 */
Route::prefix('/images')->name('web-images.')->middleware(['auth:web',])->group(function () {
    Route::post('/upload', UploadController::class)
        ->name('upload');
    Route::delete('/{image}', DeleteController::class)
        ->name('delete');
});

/**
 * Roulette
 */
Route::prefix('/roulette')->name('roulette.')->group(function () {
    Route::get('/get-pair', GetPairController::class)
        ->name('get-pair');
    Route::post('/vote/{creator}', VoteController::class)
        ->name('vote');
});

/**
 * Subscribtion
 */
Route::post('/subscribe', SubscribeController::class)
    ->middleware(['auth:web',])
    ->name('subscribe');
Route::post('/unsubscribe', UnsubscribeController::class)
    ->middleware(['auth:web',])
    ->name('unsubscribe');

/**
 * Payments
 */
Route::post('/payments/deposit', DepositController::class)
    ->middleware(['auth:web',])
    ->name('payments.deposit');
Route::post('/payments/withdraw/send-code', WithdrawSendController::class)
    ->middleware(['auth:web',])
    ->name('payments.withdraw.send-code');
Route::post('/payments/withdraw/verify-code', WithdrawVerifyController::class)
    ->middleware(['auth:web',])
    ->name('payments.withdraw.verify-code');
Route::post('/payments/withdraw/resend-code', WithdrawResendController::class)
    ->middleware(['auth:web',])
    ->name('payments.withdraw.resend-code');

/**
 * Settings
 */
Route::post('/change-email/send-code', ChangeEmailSendController::class)
    ->middleware(['auth:web',])
    ->name('change-email.send-code');
Route::post('/change-email/verify-code', ChangeEmailVerifyController::class)
    ->middleware(['auth:web',])
    ->name('change-email.verify-code');
Route::post('/change-email/resend-code', ChangeEmailResendController::class)
    ->middleware(['auth:web',])
    ->name('change-email.resend-code');

Route::post('/change-password', ChangePasswordController::class)
    ->middleware(['auth:web',])
    ->name('change-password.resend-code');

/**
 * Logs
 */
Route::get('logs', [LogViewerController::class, 'index'])
    ->middleware(['auth:sanctum',])
    ->can('logs');

/**
 * 404
 */
Route::fallback(function() {
    return view('errors.404');
});