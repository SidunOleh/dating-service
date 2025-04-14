<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\DepositRequest;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(DepositRequest $request)
    {
        $data = $request->validated();

        $creator = Auth::guard('web')->user();

        $transaction = $this->balancesService->depositBalance($creator, 0, $data['gateway'], $data);
        
        $transaction->load('details');

        return response($transaction);
    }
}
