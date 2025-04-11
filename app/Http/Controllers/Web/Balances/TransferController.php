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
            $this->balancesService->transfer(Auth::guard('web')->user(), 1);

            return response(['message' => 'OK']);
        } catch (NotEnoughMoneyException $e) {
            Log::error($e);

            return response(['message' => 'Not enough money.'], 400);
        }
    }
}
