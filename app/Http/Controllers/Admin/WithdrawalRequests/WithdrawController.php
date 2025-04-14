<?php

namespace App\Http\Controllers\Admin\WithdrawalRequests;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(WithdrawalRequest $withdrawalRequest)
    {
        try {
            $user = Auth::guard('admin')->user();

            $this->balancesService->withdrawBalance(
                $withdrawalRequest->creator,
                $withdrawalRequest,
                $user
            );

            return response(['message' => 'OK',]);
        } catch (NotEnoughMoneyException $e) {
            return response(['message' => 'Balance is too low!',], 400);
        }
    }
}
