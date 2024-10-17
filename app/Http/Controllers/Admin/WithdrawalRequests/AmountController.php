<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\PaymentGateways\PaymentGateway;
use Exception;
use Illuminate\Support\Facades\Log;

class AmountController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        try {
            $passimpay = PaymentGateway::create('crypto');

            $amount = $passimpay->convertFromUSD(
                $withdrawalRequest->amount,
                $withdrawalRequest->concrete->payment_id
            );

            return response(['amount' => $amount,]);
        } catch (Exception $e) {
            Log::error($e);

            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
