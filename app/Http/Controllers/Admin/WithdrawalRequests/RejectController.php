<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Events\WithdrawRequestRejected;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RejectController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        $withdrawalRequest->status = 'rejected';
        $withdrawalRequest->save();

        Log::info('withdrawal request rejected', [
            'withdrawal_request_id' => $withdrawalRequest->id,
            'user_id' => Auth::guard('admin')->id(), 
        ]);

        WithdrawRequestRejected::dispatch($withdrawalRequest);

        return response(['message' => 'OK',]);
    }
}
