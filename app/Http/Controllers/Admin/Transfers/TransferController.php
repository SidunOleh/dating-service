<?php

namespace App\Http\Controllers\Admin\Transfers;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Services\Balances\BalancesService;

class TransferController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(Creator $creator)
    {
        $this->balancesService->transferBalanceEarnBalance($creator);

        return response(['message' => 'OK']);
    }
}
