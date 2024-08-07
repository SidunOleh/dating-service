<?php

namespace App\Http\Controllers\Web\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayWebhookLog;
use App\Models\PlisioInvoice;
use App\Services\PaymentGateways\Plisio\Api\Invoice\Exceptions\InvoiceUnverifyResponseException;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use Exception;
use Illuminate\Http\Request;

class PlisioCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $webhookLog = PaymentGatewayWebhookLog::create([
            'gateway' => 'plisio',
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers' => $request->headers->all(),
            'body' => $request->all(),
        ]);

        try {
            $client = new PlisioClient(env('PLISIO_SECRET_KEY'));

            if (! $client->verifyData($data = $request->all())) {
                throw new InvoiceUnverifyResponseException();
            }
    
            if ($data['ipn_type'] == 'invoice') {
                $invoice = PlisioInvoice::where('txn_id', $data['txn_id'])->firstOrFail();
                
                $invoice->webhookCallback($data);
            }
        } catch (Exception $e) {
            $webhookLog->update([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
