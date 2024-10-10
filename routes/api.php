<?php

use App\Http\Controllers\Admin\Ads\DeleteController as AdsDeleteController;
use App\Http\Controllers\Admin\Ads\IndexController as AdsIndexController;
use App\Http\Controllers\Admin\Ads\StoreController as AdsStoreController;
use App\Http\Controllers\Admin\Ads\UpdateController as AdsUpdateController;
use App\Http\Controllers\Admin\Auth\ResetPassword;
use App\Http\Controllers\Admin\Auth\SendResetLink;
use App\Http\Controllers\Admin\Content\IndexController as ContentIndexController;
use App\Http\Controllers\Admin\Content\UpdateController as ContentUpdateController;
use App\Http\Controllers\Admin\Creators\DeleteController as CreatorsDeleteController;
use App\Http\Controllers\Admin\Creators\IndexController as CreatorsIndexController;
use App\Http\Controllers\Admin\Creators\ShowController as CreatorsShowController;
use App\Http\Controllers\Admin\Creators\StoreController as CreatorsStoreController;
use App\Http\Controllers\Admin\Creators\UpdateBalanceController;
use App\Http\Controllers\Admin\Creators\UpdateController as CreatorsUpdateController;
use App\Http\Controllers\Admin\Images\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Permissions\DeleteController as PermissionsDeleteController;
use App\Http\Controllers\Admin\Permissions\IndexController as PermissionsIndexController;
use App\Http\Controllers\Admin\Permissions\StoreController as PermissionsStoreController;
use App\Http\Controllers\Admin\ProfileRequests\DoneController;
use App\Http\Controllers\Admin\ProfileRequests\IndexController as ProfileRequestIndexController;
use App\Http\Controllers\Admin\ProfileRequests\ShowController;
use App\Http\Controllers\Admin\Roles\DeleteController as RolesDeleteController;
use App\Http\Controllers\Admin\Roles\IndexController as RolesIndexController;
use App\Http\Controllers\Admin\Roles\StoreController as RolesStoreController;
use App\Http\Controllers\Admin\Roles\UpdateController as RolesUpdateController;
use App\Http\Controllers\Admin\Settings\IndexController as SettingsIndexController;
use App\Http\Controllers\Admin\Settings\UpdateController as SettingsUpdateController;
use App\Http\Controllers\Admin\Templates\DeleteController as TemplatesDeleteController;
use App\Http\Controllers\Admin\Templates\IndexController as TemplatesIndexController;
use App\Http\Controllers\Admin\Templates\ShowController as TemplatesShowController;
use App\Http\Controllers\Admin\Templates\StoreController as TemplatesStoreController;
use App\Http\Controllers\Admin\Templates\UpdateController as TemplatesUpdateController;
use App\Http\Controllers\Admin\Transactions\IndexController as TransactionsIndexController;
use App\Http\Controllers\Admin\Users\IndexController;
use App\Http\Controllers\Admin\Users\StoreController;
use App\Http\Controllers\Admin\Users\UpdateController;
use App\Http\Controllers\Admin\Users\DeleteController;
use App\Http\Controllers\Admin\Transactions\DeleteController as TransactionsDeleteController;
use App\Http\Controllers\Admin\Warnings\DeleteController as WarningsDeleteController;
use App\Http\Controllers\Admin\Warnings\IndexController as WarningsIndexController;
use App\Http\Controllers\Admin\Warnings\ShowSettingsController;
use App\Http\Controllers\Admin\Warnings\StoreController as WarningsStoreController;
use App\Http\Controllers\Admin\Warnings\UpdateController as WarningsUpdateController;
use App\Http\Controllers\Admin\Warnings\UpdateSettingsController;
use App\Http\Controllers\Admin\WithdrawalRequests\AmountController;
use App\Http\Controllers\Admin\WithdrawalRequests\DeleteController as WithdrawalRequestsDeleteController;
use App\Http\Controllers\Admin\WithdrawalRequests\IndexController as WithdrawalRequestsIndexController;
use App\Http\Controllers\Admin\WithdrawalRequests\RejectController;
use App\Http\Controllers\Admin\WithdrawalRequests\WithdrawController;
use App\Http\Controllers\Admin\ZipCodes\ShowController as ZipCodesShowController;

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

Route::name('password.')->group(function () {
    Route::post('/send-reset-link', SendResetLink::class)
        ->name('send-reset-link');
    Route::post('/reset-password', ResetPassword::class)
        ->name('reset');
});

Route::middleware(['auth:sanctum',])->group(function () {
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', IndexController::class)
            ->name('index')
            ->can('users.view');
        Route::post('/', StoreController::class)  
            ->name('store')
            ->can('users.create');
        Route::put('/{user}', UpdateController::class)  
            ->name('update')
            ->can('users.edit');
        Route::delete('/{user}', DeleteController::class)  
            ->name('delete')
            ->can('users.delete');
    });

    Route::prefix('/roles')->name('roles.')->group(function () {
        Route::get('/', RolesIndexController::class)
            ->name('index')
            ->can('users.view');
        Route::post('/', RolesStoreController::class)  
            ->name('store')
            ->can('users.create');
        Route::put('/{role}', RolesUpdateController::class)  
            ->name('update')
            ->can('users.edit');
        Route::delete('/{role}', RolesDeleteController::class)  
            ->name('delete')
            ->can('users.delete');
    });

    Route::prefix('/permissions')->name('permissions.')->group(function () {
        Route::get('/', PermissionsIndexController::class)
            ->name('index')
            ->can('users.view');
        Route::post('/', PermissionsStoreController::class)  
            ->name('store')
            ->can('users.create');
        Route::delete('/{permission}', PermissionsDeleteController::class)  
            ->name('delete')
            ->can('users.delete');
    });

    Route::prefix('/templates')->name('templates.')->group(function () {
        Route::get('/', TemplatesIndexController::class)
            ->name('index')
            ->can('templates.view');
        Route::get('/{template}', TemplatesShowController::class)
            ->name('show')
            ->can('templates.show');
        Route::post('/', TemplatesStoreController::class)  
            ->name('store')
            ->can('templates.create');
        Route::put('/{template}', TemplatesUpdateController::class)  
            ->name('update')
            ->can('templates.edit');
        Route::delete('/{template}', TemplatesDeleteController::class)  
            ->name('delete')
            ->can('templates.delete');
    });

    Route::prefix('/images')->name('images.')->group(function () {
        Route::post('/upload', UploadController::class)
            ->name('upload');
    });

    Route::prefix('/ads')->name('ads.')->group(function () {
        Route::get('/', AdsIndexController::class)
            ->name('index')
            ->can('ads.view');
        Route::post('/', AdsStoreController::class)  
            ->name('store')
            ->can('ads.create');
        Route::put('/{ad}', AdsUpdateController::class)  
            ->name('update')
            ->can('ads.edit');
        Route::delete('/{ad}', AdsDeleteController::class)  
            ->name('delete')
            ->can('ads.delete');
    });

    Route::prefix('/warnings')->name('warnings.')->group(function () {
        Route::get('/', WarningsIndexController::class)
            ->name('index')
            ->can('warnings.view');
        Route::post('/', WarningsStoreController::class)  
            ->name('store')
            ->can('warnings.create');
        Route::put('/{warning}', WarningsUpdateController::class)  
            ->name('update')
            ->can('warnings.edit');
        Route::delete('/{warning}', WarningsDeleteController::class)  
            ->name('delete')
            ->can('warnings.delete');
        Route::get('/settings', ShowSettingsController::class)  
            ->name('settings.show')
            ->can('warnings.settings.show');
        Route::post('/settings', UpdateSettingsController::class)  
            ->name('settings.update')
            ->can('warnings.settings.update');
    });

    Route::prefix('/creators')->name('creators.')->group(function () {
        Route::get('/', CreatorsIndexController::class)
            ->name('index')
            ->can('creators.view');
        Route::get('/{creator}', CreatorsShowController::class)
            ->name('show')
            ->can('creators.show');
        Route::post('/', CreatorsStoreController::class)  
            ->name('store')
            ->can('creators.create');
        Route::put('/{creator}', CreatorsUpdateController::class)  
            ->name('update')
            ->can('creators.edit');
        Route::delete('/{creator}', CreatorsDeleteController::class)  
            ->name('delete')
            ->can('creators.delete');
        Route::post('/{creator}/balance', UpdateBalanceController::class)  
            ->name('update.balance')
            ->can('creators.edit-balance');
    });

    Route::prefix('/profile-requests')->name('profile-requests')->group(function () {
        Route::get('/', ProfileRequestIndexController::class)
            ->name('index')
            ->can('approved-creators.profile-requests.view|not-approved-creators.profile-requests.view');
        Route::get('/{profileRequest}', ShowController::class)
            ->name('show')
            ->can('approved-creators.profile-requests.show|not-approved-creators.profile-requests.show');
        Route::put('/{profileRequest}', DoneController::class)
            ->name('update')
            ->can('approved-creators.profile-requests.done|not-approved-creators.profile-requests.done');
    });

    Route::prefix('/transactions')->name('transactions')->group(function () {
        Route::get('/', TransactionsIndexController::class)
            ->name('index')
            ->can('transactions.view');
        Route::delete('/{transaction}', TransactionsDeleteController::class)  
            ->name('delete')
            ->can('transactions.delete');
    });

    Route::prefix('/withdrawal-requests')->name('withdrawal-requests.')->group(function () {
        Route::get('/', WithdrawalRequestsIndexController::class)
            ->name('index')
            ->can('withdrawal-requests.view');
        Route::delete('/{withdrawalRequest}', WithdrawalRequestsDeleteController::class)  
            ->name('delete')
            ->can('withdrawal-requests.delete');
        Route::get('/{withdrawalRequest}/amount', AmountController::class)  
            ->name('amount')
            ->can('withdrawal-requests.withdraw');
        Route::post('/{withdrawalRequest}/withdraw', WithdrawController::class)  
            ->name('withdraw')
            ->can('withdrawal-requests.withdraw');
        Route::post('/{withdrawalRequest}/reject', RejectController::class)  
            ->name('reject')
            ->can('withdrawal-requests.withdraw');
    });

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', SettingsIndexController::class)
            ->name('index')
            ->can('settings.view');
        Route::post('/', SettingsUpdateController::class)
            ->name('update')
            ->can('settings.edit');
    });

    Route::get('/zips/{zipCode:zip}', ZipCodesShowController::class)
        ->name('zips.show');

    Route::prefix('/content')->name('content.')->group(function () {
        Route::get('/', ContentIndexController::class)
            ->name('index')
            ->can('content.view');
        Route::post('/', ContentUpdateController::class)
            ->name('update')
            ->can('content.edit');
    });
});