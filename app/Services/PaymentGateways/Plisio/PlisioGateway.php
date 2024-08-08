<?php

namespace App\Services\PaymentGateways\Plisio;

use App\Models\Creator;
use App\Models\PlisioInvoice;
use App\Models\PlisioWithdrawal;
use App\Models\Transaction;
use App\Services\PaymentGateways\Plisio\Api\Invoice\InvoiceRequest;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use App\Services\PaymentGateways\PaymentGateway;
use App\Services\PaymentGateways\Plisio\Api\Withdrawal\WithdrawalRequest;

class PlisioGateway extends PaymentGateway
{
    private PlisioClient $client;

    public function __construct(PlisioClient $client)
    {
        $this->client = $client;
    }

    public function deposit(
        Creator $creator,
        float $amount, 
        array $data = []
    ): Transaction
    {
        $request = new InvoiceRequest(
            uniqid($creator->id, true),
            'deposit', 
            currency: $data['currency'],
            sourceAmount: $amount, 
            sourceCurrency: 'USD'
        );

        $response = $this->client->createWhiteLabelInvoice($request);

        $invoice = PlisioInvoice::create($response->toArray());
        
        $transaction = $invoice->transaction()->create([
            'gateway' => 'plisio',
            'type' => 'invoice',
            'amount' => $amount,
            'status' => 'new',
            'creator_id' => $creator->id,
        ]);

        return $transaction;
    }

    public function withdraw(
        Creator $creator,
        float $amount, 
        array $data = []
    ): Transaction
    {
        $rate = $this->client->rate('USD', $data['currency']);
        
        $currencyAmount = $rate * $amount;

        $withdrawalResponse = $this->client->createWithdrawal(
            new WithdrawalRequest(
                $currencyAmount, 
                $data['currency'], 
                $data['to'], 
                'cash_out'
            )
        );

        $withdrawal = PlisioWithdrawal::create(
            $withdrawalResponse->toArray()
        );

        $transaction = $withdrawal->transaction()->create([
            'gateway' => 'plsio',
            'type' => 'withdrawal',
            'amount' => $amount,
            'status' => $withdrawal->status,
            'creator_id' => $creator->id,
        ]);

        return $transaction;
    }
}