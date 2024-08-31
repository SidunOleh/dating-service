<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Events\WithdrawRequestSuccess;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        try {
            $withdrawalRequest->withdraw();

            Log::info('withdrawal request approved', [
                'withdrawal_request_id' => $withdrawalRequest->id,
                'user_id' => Auth::guard('admin')->id(), 
            ]);

            WithdrawRequestSuccess::dispatch($withdrawalRequest);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            Log::error($e, [
                'withdrawal_request_id' => $withdrawalRequest->id,
                'user_id' => Auth::guard('admin')->id(), 
            ]);

            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
