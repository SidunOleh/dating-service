<?php

namespace App\Http\Controllers\Admin\TransferRequests;

use App\Http\Controllers\Controller;
use App\Models\TransferRequest;
use App\Services\Balances\BalancesService;

class RejectController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(TransferRequest $transferRequest)
    {
        $this->balancesService->rejectTransferRequest($transferRequest->creator, $transferRequest);

        return response(['message' => 'OK']);
    }
}
