<?php

namespace App\Services\PaymentGateways\Passimpay;

use App\Constants\Transactions;
use App\Exceptions\CurrencyNotFoundException;
use App\Exceptions\PassimpaySignatureException;
use App\Models\Creator;
use App\Models\PassimpayDeposit;
use App\Models\PassimpayWithdrawal;
use App\Models\Transaction;
use App\Services\PaymentGateways\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PassimpayGateway extends PaymentGateway
{
    private PassimpayApi $client;

    public function __construct(PassimpayApi $client)
    {
        $this->client = $client;
    }

    public function deposit(
        Creator $creator,
        float $amount, 
        array $data = []
    ): Transaction
    {
        DB::beginTransaction();

        $deposit = PassimpayDeposit::create();

        $response = $this->client->address(
            $data['payment_id'],
            $deposit->id
        );

        $deposit->update([
            'payment_id' => $data['payment_id'],
            'address_to' => $response['address'],
        ]);

        $transaction = $deposit->transaction()->create([
            'gateway' => Transactions::GATEWAYS['crypto'],
            'type' => Transactions::PASSIMPAY_TYPES['deposit'],
            'amount' => $amount,
            'status' => Transactions::PASSIMPAY_DEPOSIT_STATUS['new'],
            'creator_id' => $creator->id,
        ]);

        DB::commit();

        return $transaction;
    }

    public function handleWebhook(Request $request): Transaction
    {
        $data = $request->all();

        $signature = $this->client->signature($data);

        if ($signature != $request->header('x-signature')) {
            throw new PassimpaySignatureException();
        }

        DB::beginTransaction();

        $deposit = PassimpayDeposit::findOrFail($data['orderId']);

        $deposit->update([
            'payment_id' => $data['paymentId'],
            'amount' => $data['amount'],
            'txhash' => $data['txhash'],
            'address_from' => $data['addressFrom'],
            'address_to' => $data['addressTo'],
            'confirmations' => $data['confirmations'],
            'destination_tag' => $data['destinationTag'],
        ]);
        
        $amount = $this->cryptoToUsd($data['amount'], $data['paymentId']);

        $transaction = $deposit->transaction;

        $transaction->update([
            'amount' => $amount,
            'status' => Transactions::PASSIMPAY_DEPOSIT_STATUS['transfered'],
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
        $cryptoAmount = $this->usdToCrypto($amount, $data['payment_id']);

        $response = $this->client->withdraw(
            $data['payment_id'], 
            $data['address_to'], 
            $cryptoAmount
        );

        DB::beginTransaction();

        $withdrawal = PassimpayWithdrawal::create([
            'payment_id' => $response['paymentId'],
            'address_to' => $response['addressTo'],
            'amount' => $response['amount'],
            'transaction_id' => $response['transactionId'],
        ]);

        $transaction = $withdrawal->transaction()->create([
            'gateway' => Transactions::GATEWAYS['crypto'],
            'type' => Transactions::PASSIMPAY_TYPES['withdrawal'],
            'amount' => $amount,
            'creator_id' => $creator->id,
            'status' => Transactions::PASSIMPAY_WITHDRAWAL_STATUS['pending'],
        ]);

        DB::commit();

        return $transaction;
    }

    public function updateWithdrawalStatus(Transaction $transaction): void
    {
        $status = [
            Transactions::PASSIMPAY_WITHDRAWAL_STATUS['pending'],
            Transactions::PASSIMPAY_WITHDRAWAL_STATUS['succes'],
            Transactions::PASSIMPAY_WITHDRAWAL_STATUS['error'],
        ];

        $response = $this->client->withdrawstatus(
            $transaction->details->transaction_id
        );

        $transaction->update([
            'status' => $status[$response['approve']],
        ]);
    }

    public function usdToCrypto(float $amountUsd, int $paymentId): float
    {
        $response = $this->client->currencies();

        foreach ($response['list'] as $currency) {
            if ($paymentId == $currency['id']) {
                return $amountUsd / $currency['rateUsd'];
            }
        }

        throw new CurrencyNotFoundException();
    }

    public function cryptoToUsd(float $amountCrypto, int $paymentId): float
    {
        $response = $this->client->currencies();

        foreach ($response['list'] as $currency) {
            if ($paymentId == $currency['id']) {
                return $amountCrypto * $currency['rateUsd'];
            }
        }

        throw new CurrencyNotFoundException;
    }
}