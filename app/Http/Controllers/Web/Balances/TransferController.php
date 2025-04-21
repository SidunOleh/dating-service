<?php

namespace App\Http\Controllers\Web\Balances;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();

            $creator = Creator::lockForUpdate()->find(Auth::guard('web')->id());

            $this->balancesService->transferBalanceBalance2($creator, 1);

            DB::commit();

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
