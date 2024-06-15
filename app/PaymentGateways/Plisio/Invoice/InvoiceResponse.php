<?php

namespace App\PaymentGateways\Plisio\Invoice;

class InvoiceResponse
{
    public function __construct(
        protected string $txnId,
        protected string $invoiceUrl
    )
    {
        
    }

    public function txnId(): string
    {
        return $this->txnId;
    }

    public function invoiceUrl(): string
    {
        return $this->invoiceUrl;
    }

    public function toArray(): array
    {
        $response['txn_id'] = $this->txnId;
        $response['invoice_url'] = $this->invoiceUrl; 

        return $response;
    }
}