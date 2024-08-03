<?php

namespace App\Services\PaymentGateways;

use App\Models\Creator;
use App\Models\Transaction;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use App\Services\PaymentGateways\Plisio\PlisioGateway;

abstract class PaymentGateway
{
    abstract public function deposit(
        Creator $creator,
        float $amount, 
        array $data = []
    ): Transaction;

    abstract public function withdraw(
        Creator $creator,
        float $amount, 
        array $data = []
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