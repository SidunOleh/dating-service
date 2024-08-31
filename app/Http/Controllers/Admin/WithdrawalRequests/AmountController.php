<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use Exception;
use Illuminate\Support\Facades\Log;

class AmountController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        try {
            $plisioClient = new PlisioClient(config('services.plisio.secret'));

            $rate = $plisioClient->rate('USD', $withdrawalRequest->concrete->currency);

            $amount = $rate * $withdrawalRequest->amount;

            return response(['amount' => $amount,]);
        } catch (Exception $e) {
            Log::error($e);

            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
