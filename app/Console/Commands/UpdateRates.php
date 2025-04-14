<?php

namespace App\Console\Commands;

use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use Illuminate\Console\Command;

class UpdateRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plisio:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currencies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $plisio = new PlisioClient(config('services.plisio.secret'));

        $rates = [];
        foreach (config('services.plisio.currencies', []) as $currency) {
            $rates[$currency] = $plisio->rate('USD', $currency);
        }

        cache(['rates' => $rates,]);
    }
}
