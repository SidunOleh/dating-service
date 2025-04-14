<?php

namespace App\Http\Controllers\Web\Webhooks;

use App\Constants\Transactions;
use App\Http\Controllers\Controller;
use App\Services\Balances\BalancesService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PassimpayCallbackController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        try {
            Log::info('passimpay webhook', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->all(),
            ]);
            
            $this->balancesService->handleDepositWebhook(Transactions::GATEWAYS['crypto'], $request);

            return response('OK');
        } catch (Exception $e) {            
            Log::error($e, [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->all(),
            ]);

            return response('Error', 500);
        }
    }
}
