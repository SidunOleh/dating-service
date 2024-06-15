<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;

class RejectController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        $withdrawalRequest->status = 'rejected';
        $withdrawalRequest->save();

        return response(['message' => 'OK',]);
    }
}
