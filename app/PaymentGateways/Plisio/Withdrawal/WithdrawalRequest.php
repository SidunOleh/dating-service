<?php

namespace App\PaymentGateways\Plisio\Withdrawal;

class WithdrawalRequest
{
    public function __construct(
        private float $amount,
        private string $currency,
        private string $to,
        private string $type
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

    public function to(): float
    {
        return $this->to;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        $request = [];
        $request['amount'] = $this->amount;
        $request['currency'] = $this->currency; 
        $request['to'] = $this->to; 
        $request['type'] = $this->type; 

        return $request;
    }
}