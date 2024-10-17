<?php

namespace App\Services\PaymentGateways\Passimpay;

use App\Models\Creator;
use App\Models\PassimpayDeposit;
use App\Models\PassimpayWithdrawal;
use App\Models\Transaction;
use App\Services\PaymentGateways\PaymentGateway;
use Exception;

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
            'gateway' => 'crypto',
            'type' => 'deposit',
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
        $cryptoAmount = $this->convertFromUSD($amount, $data['payment_id']);

        $response = $this->client->withdraw(
            $data['payment_id'], 
            $data['address_to'], 
            $cryptoAmount
        );

        $withdrawal = PassimpayWithdrawal::create([
            'payment_id' => $response['payment_id'],
            'address_to' => $response['address_to'],
            'amount' => $response['amount'],
            'transaction_id' => $response['transaction_id'],
        ]);

        $transaction = $withdrawal->transaction()->create([
            'gateway' => 'crypto',
            'type' => 'withdrawal',
            'amount' => $amount,
            'creator_id' => $creator->id,
            'status' => 'pending',
        ]);

        return $transaction;
    }

    public function convertFromUSD(float $amount, int $paymentId): float
    {
        $response = $this->client->currencies();

        foreach ($response['list'] as $currency) {
            if ($paymentId == $currency['id']) {
                return $amount / $currency['rateUsd'];
            }
        }

        throw new Exception('Can not convert.');
    }

    public function convertToUSD(float $amount, int $paymentId): float
    {
        $response = $this->client->currencies();

        foreach ($response['list'] as $currency) {
            if ($paymentId == $currency['id']) {
                return $amount * $currency['rateUsd'];
            }
        }

        throw new Exception('Can not convert.');
    }
}