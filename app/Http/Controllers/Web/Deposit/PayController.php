<?php

namespace App\Http\Controllers\Web\Deposit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Deposit\PayRequest;
use App\Services\PaymentGateways\PaymentGateway;

class PayController extends Controller
{
    public function __invoke(PayRequest $request, string $gateway)
    {
        $usdAmount = $request->input('usd_amount', 5);
        $currency = $request->input('currency', 'BTC');

        $paymentGateway = PaymentGateway::create($gateway);

        $transaction = $paymentGateway->pay($usdAmount, $currency);

        $transaction->details;

        return response(['transaction' => $transaction,]);
    }
}
