<?php

namespace App\Console\Commands;

use App\Services\PaymentGateways\Passimpay\PassimpayApi;
use Illuminate\Console\Command;

class PassimpayRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passimpay:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Passimpay rates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $passimpay = new PassimpayApi(
            config('services.passimpay.platform_id'),
            config('services.passimpay.secret_key')
        );

        $response = $passimpay->currencies();
        $rates = [];
        foreach ($response['list'] as $currency) {
            $rates[$currency['id']] = $currency['rateUsd'];
        }

        cache(['rates' => $rates,]);
    }
}
