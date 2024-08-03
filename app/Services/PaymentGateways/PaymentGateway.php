<?php

namespace App\Services\PaymentGateways;

use App\Models\Transaction;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use App\Services\PaymentGateways\Plisio\PlisioGateway;

abstract class PaymentGateway
{
    abstract public function pay(
        float $usdAmount, 
        string $currency
    ): Transaction;

    public static function create(string $gateway): self
    {
        switch ($gateway) {
            case 'plisio':
                return new PlisioGateway(new PlisioClient(env('PLISIO_SECRET_KEY')));
            default:
                throw new PaymentGatewayNotFound();
        }
    }
}