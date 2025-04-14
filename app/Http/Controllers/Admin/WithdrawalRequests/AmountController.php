<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Constants\Transactions;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\PaymentGateways\PaymentGateway;

class AmountController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        $passimpay = PaymentGateway::create(Transactions::GATEWAYS['crypto']);

        $amount = $passimpay->usdToCrypto(
            $withdrawalRequest->amount,
            $withdrawalRequest->concrete->payment_id
        );

        return response(['amount' => $amount,]);
    }
}
