<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Events\WithdrawRequestSuccess;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        try {
            $withdrawalRequest->withdraw();

            WithdrawRequestSuccess::dispatch($withdrawalRequest);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            Log::error($e->getMessage(), [
                'withdrawal_request' => $withdrawalRequest->id,
            ]);

            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
