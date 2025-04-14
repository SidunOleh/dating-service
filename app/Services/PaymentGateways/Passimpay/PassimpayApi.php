<?php

namespace App\Services\PaymentGateways\Passimpay;

use App\Exceptions\PassimpayApiException;
use Illuminate\Support\Facades\Http;

class PassimpayApi
{
    private string $platformId;

    private string $secretKey;

    private string $baseUrl = 'https://api.passimpay.io/v2';

    public function __construct(
        string $platformId,
        string $secretKey
    )
    {
        $this->platformId = $platformId;
        $this->secretKey = $secretKey;
    }

    public function currencies(): array
    {
        $response = $this->request("{$this->baseUrl}/currencies");

        return $response;
    }

    public function address(int $paymentId, string $orderId): array
    {
        $response = $this->request("{$this->baseUrl}/address", [
            'paymentId' => $paymentId,
            'orderId' => $orderId,
        ]);

        return $response;
    }

    public function withdraw(
        int $paymentId,
        string $addressTo,
        string $amount
    ): array
    {
        $response = $this->request("{$this->baseUrl}/withdraw", [
            'paymentId' => $paymentId,
            'addressTo' => $addressTo,
            'amount' => $amount,
        ]);

        return $response;
    }

    public function withdrawstatus(string $transactionId): array
    {
        $response = $this->request("{$this->baseUrl}/withdrawstatus", [
            'transactionId' => $transactionId,
        ]);

        return $response;
    }

    private function request(string $url, array $data = []): array
    {
        $data['platformId'] = $this->platformId;

        $signature = $this->signature($data);

        $response = Http::withHeaders([
            'x-signature' => $signature,
        ])->withBody(json_encode($data), 'application/json')->post($url);

        $json = $response->json();

        if ($json['result'] == 0) {
            throw new PassimpayApiException($json['message']);
        }

        return $json;
    }

    public function signature(array $data): string
    {
        $signature = hash_hmac(
            'sha256', 
            $this->platformId . ';' . json_encode($data) . ';' . $this->secretKey, 
            $this->secretKey
        );

        return $signature;
    }
}