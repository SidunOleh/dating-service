<?php

namespace App\Services\PaymentGateways\Plisio;

use App\Models\PlisioInvoice;
use App\Models\Transaction;
use App\Services\PaymentGateways\Plisio\Api\Invoice\InvoiceRequest;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use App\Services\PaymentGateways\PaymentGateway;
use Illuminate\Support\Facades\Auth;

class PlisioGateway extends PaymentGateway
{
    private PlisioClient $client;

    public function __construct(PlisioClient $client)
    {
        $this->client = $client;
    }

    public function pay(
        float $usdAmount,
        string $currency 
    ): Transaction
    {
        $request = new InvoiceRequest(
            uniqid(Auth::id(), true), 
            'deposit', 
            currency: $currency,
            sourceAmount: $usdAmount, 
            sourceCurrency: 'USD'
        );

        $response = $this->client->createWhiteLabelInvoice($request);

        $invoice = PlisioInvoice::create($response->toArray());
        
        $transaction = Transaction::create([
            'gateway' => 'plisio',
            'type' => 'invoice',
            'usd_amount' => $usdAmount,
            'status' => 'new',
            'details_type' => PlisioInvoice::class,
            'details_id' => $invoice->id,
            'creator_id' => Auth::id(),
        ]);

        return $transaction;
    }
}