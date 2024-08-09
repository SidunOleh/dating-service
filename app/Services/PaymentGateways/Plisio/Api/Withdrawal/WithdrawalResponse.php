<?php

namespace App\Services\PaymentGateways\Plisio\Api\Withdrawal;

class WithdrawalResponse
{
    public function __construct(
        private float $amount,
        private string $currency,
        private string $status,
        private string $sourceCurrency,
        private float $sourceRate,
        private float $fee,
        private string $id,
        private string $type,
        private ?string $walletHash = null,
        private ?array $sendmany = null
    )
    {

    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function sourceCurrency(): string
    {
        return $this->sourceCurrency;
    }

    public function sourceRate(): float
    {
        return $this->sourceRate;
    }

    public function fee(): float
    {
        return $this->fee;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function walletHash(): ?string
    {
        return $this->walletHash;
    }

    public function sendmany(): ?array
    {
        return $this->sendmany;
    }

    public function toArray(): array
    {
        $response = [];
        $response['amount'] = $this->amount;
        $response['currency'] = $this->currency;
        $response['status'] = $this->status;
        $response['source_currency'] = $this->sourceCurrency;
        $response['source_rate'] = $this->sourceRate;
        $response['fee'] = $this->fee;
        $response['plisio_id'] = $this->id;
        $response['type'] = $this->type;
        $response['wallet_hash'] = $this->walletHash;
        $response['sendmany'] = $this->sendmany;

        return $response;
    }
}