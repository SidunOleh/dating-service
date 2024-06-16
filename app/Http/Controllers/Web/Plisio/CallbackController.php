<?php

namespace App\Http\Controllers\Web\Plisio;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayWebhookLog;
use App\Models\PlisioInvoice;
use App\PaymentGateways\Plisio\Invoice\Exceptions\InvoiceUnverifyResponseException;
use App\PaymentGateways\Plisio\PlisioClient;
use Exception;
use Illuminate\Http\Request;

class CallbackController extends Controller
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
                
                $invoice->changeStatus($data['status']);
            }
        } catch (Exception $e) {
            $webhookLog->exception = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            $webhookLog->save();
        }
    }
}
