<?php

namespace App\Services\PaymentGateways\Plisio\Api\Invoice;

class InvoiceRequest
{
    public function __construct(
        private string $orderNumber,
        private string $orderName,
        private ?float $amount = null,
        private ?string $currency = null,
        private ?float $sourceAmount = null,
        private ?string $sourceCurrency = null
    )
    {
        
    }

    public function orderNumber(): string
    {
        return $this->orderNumber;
    }

    public function orderName(): string
    {
        return $this->orderName;
    }

    public function amount(): ?float
    {
        return $this->amount;
    }

    public function currency(): ?string
    {
        return $this->currency;
    }

    public function sourceAmount(): ?float
    {
        return $this->sourceAmount;
    }

    public function sourceCurrency(): ?string
    {
        return $this->sourceCurrency;
    }

    public function toArray(): array
    {
        $request = [];
        $request['order_number'] = $this->orderNumber;
        $request['order_name'] = $this->orderName; 

        if ($this->currency) {
            $request['currency'] = $this->currency; 
        }

        if ($this->amount) {
            $request['amount'] = $this->amount; 
        } else {
            $request['source_amount'] = $this->sourceAmount; 
            $request['source_currency'] = $this->sourceCurrency; 
        }

        return $request;
    }
}