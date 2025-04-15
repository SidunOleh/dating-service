<?php

namespace App\Http\Controllers\Web\Balances;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Balances\TransferToBalanceRequest;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;
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
            $creator = Auth::guard('web')->user();

            if ($creator->transferRequestInPending) {
                return response(['message' => 'Oops.'], 400);
            }

            $this->balancesService->createTransferRequest($creator, $request->amount);

            return response(['message' => 'OK']);
        } catch (NotEnoughMoneyException $e) {
            Log::error($e);

            return response(['message' => 'Balance is too low!'], 400);
        }
    }
}
