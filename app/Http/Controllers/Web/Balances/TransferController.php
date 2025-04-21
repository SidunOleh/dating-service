<?php

namespace App\Http\Controllers\Web\Balances;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Services\Balances\BalancesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransferController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke()
    {
        try {
            $creator = Auth::guard('web')->user();

            $this->balancesService->transferBalanceBalance2($creator, 1);

            return response([
                'balance' => $creator->balance, 
                'balance_2' => $creator->balance_2_total,
            ]);
        } catch (NotEnoughMoneyException $e) {
            Log::error($e);

            return response(['message' => 'Balance is too low!'], 400);
        }
    }
}
