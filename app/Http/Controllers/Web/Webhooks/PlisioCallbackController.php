<?php

namespace App\Http\Controllers\Web\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PlisioInvoice;
use App\Services\PaymentGateways\Plisio\Api\Invoice\Exceptions\InvoiceUnverifyResponseException;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlisioCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            Log::info('plisio webhook', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->except(['qr_code',]),
            ]);
            
            $client = new PlisioClient(env('PLISIO_SECRET_KEY'));

            if (! $client->verifyData($data = $request->all())) {
                throw new InvoiceUnverifyResponseException();
            }
    
            if ($data['ipn_type'] == 'invoice') {
                $invoice = PlisioInvoice::where('txn_id', $data['txn_id'])->firstOrFail();
                
                $invoice->webhookCallback($data);
            }
        } catch (Exception $e) {
            Log::error($e, [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->except(['qr_code',]),
            ]);
        }
    }
}
