<?php

namespace App\Http\Controllers\Web\Balances;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Balances\TransferToBalanceRequest;
use App\Models\Creator;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferToBalanceController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(TransferToBalanceRequest $request)
    {
        try {
            DB::beginTransaction();

            $creator = Creator::lockForUpdate()->find(Auth::guard('web')->id());

            if ($creator->transferRequestInPending) {
                DB::commit();
                
                return response(['message' => 'Oops.'], 400);
            }

            $this->balancesService->createTransferRequest($creator, $request->amount);

            DB::commit();

            return response(['message' => 'OK']);
        } catch (NotEnoughMoneyException $e) {
            DB::rollBack();

            Log::error($e);

            return response(['message' => 'Balance is too low!'], 400);
        }
    }
}
