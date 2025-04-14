<?php

namespace App\Http\Controllers\Web\Webhooks;

use App\Constants\Transactions;
use App\Http\Controllers\Controller;
use App\Services\Balances\BalancesService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlisioCallbackController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        try {
            Log::info('plisio webhook', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->except(['qr_code',]),
            ]);
            
            $this->balancesService->handleDepositWebhook(Transactions::GATEWAYS['plisio'], $request);

            return response('OK');
        } catch (Exception $e) {
            Log::error($e, [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->except(['qr_code',]),
            ]);

            return response('Error', 500);
        }
    }
}
