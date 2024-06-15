<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;

class DeleteController extends Controller
{
    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        $withdrawalRequest->concrete->delete();
        $withdrawalRequest->delete();

        return response(['message' => 'OK',]);
    }
}
