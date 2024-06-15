<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\PaymentGateways\Plisio\PlisioClient;
use Exception;

class AmountController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        try {
            $plisioClient = new PlisioClient(env('PLISIO_SECRET_KEY'));

            $rate = $plisioClient->rate('USD', $withdrawalRequest->concrete->currency);
            $amount = $rate * $withdrawalRequest->usd_amount;

            return response(['amount' => $amount,]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
