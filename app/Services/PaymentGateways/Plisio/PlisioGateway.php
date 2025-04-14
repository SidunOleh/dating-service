<?php

namespace App\Services\PaymentGateways\Plisio;

use App\Constants\Transactions;
use App\Models\Creator;
use App\Models\PlisioInvoice;
use App\Models\PlisioWithdrawal;
use App\Models\Transaction;
use App\Services\PaymentGateways\Plisio\Api\Invoice\InvoiceRequest;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use App\Services\PaymentGateways\PaymentGateway;
use App\Services\PaymentGateways\Plisio\Api\Invoice\Exceptions\InvoiceUnverifyResponseException;
use App\Services\PaymentGateways\Plisio\Api\Withdrawal\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'gateway' => Transactions::GATEWAYS['plisio'],
            'type' => Transactions::PLISIO_TYPES['invoice'],
            'amount' => $amount,
            'status' => Transactions::PLISIO_INVOICE_STATUS['new'],
            'creator_id' => $creator->id,
        ]);

        return $transaction;
    }

    public function handleWebhook(Request $request): Transaction
    {
        if (! $this->client->verifyData($data = $request->all())) {
            throw new InvoiceUnverifyResponseException();
        }

        $invoice = PlisioInvoice::where('txn_id', $data['txn_id'])->firstOrFail();
            
        DB::beginTransaction();

        $invoice->update([
            'received' => $data['amount'],
            'status' => $data['status'],
        ]);

        $transaction = $invoice->transaction;

        $transaction->update([
            'status' => $data['status'],
        ]);

        DB::commit();

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
            'gateway' => Transactions::GATEWAYS['plisio'],
            'type' => Transactions::PLISIO_TYPES['withdrawal'],
            'amount' => $amount,
            'status' => $withdrawal->status,
            'creator_id' => $creator->id,
        ]);

        return $transaction;
    }

    public function updateWithdrawalStatus(Transaction $transaction): void
    {
        $data = $this->client->transaction($transaction->details->plisio_id);

        DB::beginTransaction();

        $transaction->details->update([
            'status' => $data['status'],
        ]);
        $transaction->update([
            'status' => $data['status'],
        ]);

        DB::commit();
    }
}