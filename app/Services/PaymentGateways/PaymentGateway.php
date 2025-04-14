<?php

namespace App\Services\PaymentGateways;

use App\Exceptions\PaymentGatewayNotFoundException;
use App\Models\Creator;
use App\Models\Transaction;
use App\Services\PaymentGateways\Passimpay\PassimpayApi;
use App\Services\PaymentGateways\Passimpay\PassimpayGateway;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use App\Services\PaymentGateways\Plisio\PlisioGateway;
use Illuminate\Http\Request;

abstract class PaymentGateway
{
    abstract public function deposit(
        Creator $creator,
        float $amount, 
        array $data = []
    ): Transaction;

    abstract public function handleWebhook(Request $request): Transaction;

    abstract public function withdraw(
        Creator $creator,
        float $amount, 
        array $data = []
    ): Transaction;

    abstract public function updateWithdrawalStatus(Transaction $transaction): void;

    public static function create(string $gateway): self
    {
        switch ($gateway) {
            case 'plisio':
                return new PlisioGateway(new PlisioClient(
                    config('services.plisio.secret')
                ));
            case 'crypto':
                return new PassimpayGateway(new PassimpayApi(
                    config('services.passimpay.platform_id'),
                    config('services.passimpay.secret_key')
                ));
            default:
                throw new PaymentGatewayNotFoundException();
        }
    }
}