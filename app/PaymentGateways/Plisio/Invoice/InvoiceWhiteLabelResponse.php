<?php

namespace App\PaymentGateways\Plisio\Invoice;

class InvoiceWhiteLabelResponse extends InvoiceResponse
{
    public function __construct(
        string $txnId,
        string $invoiceUrl,
        private float $amount,
        private string $currency,
        private string $orderNumber,
        private string $orderName,
        private string $status,
        private string $walletHash,
        private float $sourceAmount,
        private string $sourceCurrency,
        private float $sourceRate,
        private float $invoiceCommission,
        private float $invoiceSum,
        private float $invoiceTotalSum,
        private string $qrCode,
        private int $expireAtUtc
    )
    {
        parent::__construct($txnId, $invoiceUrl);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function orderNumber(): string
    {
        return $this->orderNumber;
    }
    
    public function orderName(): string
    {
        return $this->orderName;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function walletHash(): string
    {
        return $this->walletHash;
    }

    public function sourceAmount(): string
    {
        return $this->sourceAmount;
    }

    public function sourceCurrency(): string
    {
        return $this->sourceCurrency;
    }

    public function sourceRate(): float
    {
        return $this->sourceRate;
    }

    public function invoiceCommission(): float
    {
        return $this->invoiceCommission;
    }

    public function invoiceSum(): float
    {
        return $this->invoiceSum;
    }

    public function invoiceTotalSum(): float
    {
        return $this->invoiceTotalSum;
    }
    
    public function qrCode(): string
    {
        return $this->qrCode;
    }

    public function expireAtUtc(): int
    {
        return $this->expireAtUtc;
    }

    public function toArray(): array
    {
        $response = [];
        $response = parent::toArray();
        $response['amount'] = $this->amount;
        $response['currency'] = $this->currency;
        $response['order_number'] = $this->orderNumber;
        $response['order_name'] = $this->orderName;
        $response['status'] = $this->status;
        $response['wallet_hash'] = $this->walletHash;
        $response['source_amount'] = $this->sourceAmount;
        $response['source_currency'] = $this->sourceCurrency;
        $response['source_rate'] = $this->sourceRate;
        $response['invoice_sum'] = $this->invoiceSum;
        $response['invoice_commission'] = $this->invoiceCommission;
        $response['invoice_total_sum'] = $this->invoiceTotalSum;
        $response['qr_code'] = $this->qrCode;
        $response['expire_at_utc'] = $this->expireAtUtc;

        return $response;
    }
}