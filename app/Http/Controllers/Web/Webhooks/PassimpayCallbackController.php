<?php

namespace App\Http\Controllers\Web\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PassimpayDeposit;
use App\Services\PaymentGateways\Passimpay\PassimpayApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PassimpayCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            Log::info('passimpay webhook', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->all(),
            ]);
            
            $passimpayApi = new PassimpayApi(
                config('services.passimpay.platform_id'),
                config('services.passimpay.secret_key')
            );

            $signature = $passimpayApi->signature($request->all());

            if ($signature != $request->header('x-signature')) {
                throw new Exception('Passimpay signature error.');
            }

            $deposit = PassimpayDeposit::findOrFail($request->orderId);

            DB::beginTransaction();

            $deposit->update([
                'payment_id' => $request->paymentId,
                'amount' => $request->amount,
                'txhash' => $request->txhash,
                'address_from' => $request->addressFrom,
                'address_to' => $request->addressTo,
                'confirmations' => $request->confirmations,
                'destination_tag' => $request->destinationTag,
            ]);

            $deposit->transferToCreator();

            DB::commit();

            return response('OK');
        } catch (Exception $e) {
            DB::rollBack();
            
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
