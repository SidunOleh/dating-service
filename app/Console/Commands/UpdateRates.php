<?php

namespace App\Console\Commands;

use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        $plisio = new PlisioClient(env('PLISIO_SECRET_KEY'));

        $currencies = config('app.currencies');
        $rates = [];
        foreach ($currencies as $currency) {
            try {
                $rates[$currency] = $plisio->rate('USD', $currency);
            } catch (Exception $e) {
                Log::error($e);
            }
        }

        cache(['rates' => $rates,]);
    }
}
