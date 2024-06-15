<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Plisio\CallbackController;
use App\Models\PlisioInvoice;
use App\Models\PlisioWithdrawalRequest;
use App\Models\WithdrawalRequest;
use App\PaymentGateways\Plisio\Invoice\InvoiceRequest;
use App\PaymentGateways\Plisio\PlisioClient;
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


Route::get('/', function () {
    $plisioWithdrawalRequest = PlisioWithdrawalRequest::create([
        'currency' => ['BTC', 'ETH'][rand(0, 1)],
        'to' => '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX71',
    ]);

    $withdrawalRequest = WithdrawalRequest::create([
        'gateway' => 'plisio',
        'usd_amount' => 100,
        'concrete_type' => PlisioWithdrawalRequest::class,
        'concrete_id' => $plisioWithdrawalRequest->id,
        'creator_id' => 1,
    ]);

    $plisioClient = new PlisioClient(env('PLISIO_SECRET_KEY'));
    
    $plisioInvoiceResponse = $plisioClient->createWhiteLabelInvoice(new InvoiceRequest(
        rand(1, 10000), 
        'monthly subscription', 
        currency: 'ETH', 
        sourceAmount: 50, 
        sourceCurrency: 'USD'
    ));
    $plisioInvoice = PlisioInvoice::create($plisioInvoiceResponse->toArray());
    $plisioInvoice->transaction()->create([
        'gateway' => 'plisio',
        'type' => 'invoice',
        'usd_amount' => $plisioInvoice->source_amount,
        'status' => $plisioInvoice->status,
        'creator_id' => 1,
    ]);
});
