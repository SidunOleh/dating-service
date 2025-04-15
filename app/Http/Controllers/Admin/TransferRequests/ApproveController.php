<?php

namespace App\Http\Controllers\Admin\TransferRequests;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Models\TransferRequest;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Log;

class ApproveController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(TransferRequest $transferRequest)
    {
        try {
            $this->balancesService->transferBalance2Balance($transferRequest->creator, $transferRequest);

            return response(['message' => 'OK']);
        } catch (NotEnoughMoneyException $e) {
            Log::error($e);

            return response(['message' => 'Balance is too low!'], 400);
        }
    }
}
