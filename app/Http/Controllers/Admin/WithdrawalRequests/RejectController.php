<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;

class RejectController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        $user = Auth::guard('admin')->user();

        $this->balancesService->rejectWithdrawalRequest($withdrawalRequest->creator, $withdrawalRequest, $user);

        return response(['message' => 'OK',]);
    }
}
