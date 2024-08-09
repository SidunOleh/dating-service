<?php

namespace App\Services\PaymentGateways\Plisio\Api;

use App\Services\PaymentGateways\Plisio\Api\Exceptions\GetTransactionException;
use App\Services\PaymentGateways\Plisio\Api\Exceptions\RateNotFoundException;
use App\Services\PaymentGateways\Plisio\Api\Exceptions\RateRequestErrorException;
use App\Services\PaymentGateways\Plisio\Api\Invoice\Exceptions\InvoiceRequestErrorException;
use App\Services\PaymentGateways\Plisio\Api\Invoice\Exceptions\InvoiceUnverifyResponseException;
use App\Services\PaymentGateways\Plisio\Api\Invoice\InvoiceRequest;
use App\Services\PaymentGateways\Plisio\Api\Invoice\InvoiceResponse;
use App\Services\PaymentGateways\Plisio\Api\Invoice\InvoiceWhiteLabelResponse;
use App\Services\PaymentGateways\Plisio\Api\Withdrawal\Exceptions\WithdrawalRequestErrorException;
use App\Services\PaymentGateways\Plisio\Api\Withdrawal\WithdrawalRequest;
use App\Services\PaymentGateways\Plisio\Api\Withdrawal\WithdrawalResponse;
use Illuminate\Support\Facades\Http;

class PlisioClient
{
    private string $secretKey;

    private string $baseUri;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
        $this->baseUri = 'https://api.plisio.net/api/v1/';
    }

    public function createInvoice(InvoiceRequest $request): InvoiceResponse
    {
        $request = $request->toArray();
        $request['api_key'] = $this->secretKey;

        $response = Http::get("{$this->baseUri}invoices/new", $request);
        $response = $response->json();

        if ($response['status'] == 'error') {
            throw new InvoiceRequestErrorException($response['data']['message'], $response['data']['code']);
        }

        return new InvoiceResponse($response['data']['txn_id'], $response['data']['invoice_url']);
    }

    public function createWhiteLabelInvoice(InvoiceRequest $request): InvoiceWhiteLabelResponse
    {
        $request = $request->toArray();
        $request['api_key'] = $this->secretKey;

        $response = Http::get("{$this->baseUri}invoices/new", $request);
        $response = $response->json();  

        if ($response['status'] == 'error') {
            throw new InvoiceRequestErrorException($response['data']['message'], $response['data']['code']);
        }

        if (! $this->verifyData($response['data'])) {
            throw new InvoiceUnverifyResponseException();
        }

        return new InvoiceWhiteLabelResponse(
            $response['data']['txn_id'],
            $response['data']['invoice_url'],
            $response['data']['amount'],
            $response['data']['currency'],
            $response['data']['params']['order_number'],
            $response['data']['params']['order_name'], 
            $response['data']['status'],
            $response['data']['wallet_hash'],
            $response['data']['params']['source_amount'],
            $response['data']['source_currency'],
            $response['data']['source_rate'],
            $response['data']['invoice_commission'],
            $response['data']['invoice_sum'],
            $response['data']['invoice_total_sum'],
            $response['data']['qr_code'],
            $response['data']['expire_at_utc']
        );
    }

    public function verifyData(array $data): bool
    {
        if (! isset($data['verify_hash'])) {
            return false;
        }
    
        $verifyHash = $data['verify_hash'];
        unset($data['verify_hash']);
        ksort($data);
    
        if (isset($data['expire_utc'])){
            $data['expire_utc'] = (string) $data['expire_utc'];
        }
        
        if (isset($data['tx_urls'])){
            $data['tx_urls'] = html_entity_decode($data['tx_urls']);
        }
    
        $hash = hash_hmac('sha1', serialize($data), $this->secretKey);
        if ($hash == $verifyHash) {
            return true;
        }
    
        return false;
    }

    public function createWithdrawal(WithdrawalRequest $request): WithdrawalResponse
    {
        $request = $request->toArray();
        $request['api_key'] = $this->secretKey;

        $response = Http::get("{$this->baseUri}operations/withdraw", $request);
        $response = $response->json();

        if ($response['status'] == 'error') {
            throw new WithdrawalRequestErrorException($response['data']['message'], $response['data']['code']);
        }

        return new WithdrawalResponse(
            $response['data']['amount'], 
            $response['data']['currency'],
            $response['data']['status'],
            $response['data']['source_currency'],
            $response['data']['source_rate'],
            $response['data']['fee'],
            $response['data']['id'],
            $response['data']['type'],
            $response['data']['wallet_hash'] ?? null,
            $response['data']['sendmany'] ?? null
        );
    }

    public function rate(string $fiat, string $cryptocurrency): float
    {
        $response = Http::get("{$this->baseUri}currencies/{$fiat}", ['api_key' => $this->secretKey,]);
        $response = $response->json();
        
        if ($response['status'] == 'error') {
            throw new RateRequestErrorException($response['data']['message'], $response['data']['code']);
        }

        $rate = null;
        foreach ($response['data'] as $item) {
            if ($item['currency'] == $cryptocurrency) {
                $rate = (float) $item['fiat_rate'];
            }
        }

        if (! isset($rate)) {
            throw new RateNotFoundException();
        }

        return $rate;
    }

    public function transaction(string $id): array
    {
        $response = Http::get("{$this->baseUri}operations/{$id}", ['api_key' => $this->secretKey,]);
        $response = $response->json();
        
        if ($response['status'] == 'error') {
            throw new GetTransactionException($response['data']['message'], $response['data']['code']);
        }

        return $response['data'];
    }
}