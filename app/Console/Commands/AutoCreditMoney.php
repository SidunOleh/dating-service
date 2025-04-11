<?php

namespace App\Console\Commands;

use App\Constants\Balances;
use App\Models\Creator;
use App\Services\Balances\BalancesService;
use Illuminate\Console\Command;

class AutoCreditMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balances:auto-credit-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto credit money';

    public function __construct(
        private BalancesService $balancesService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Creator::whereRaw('balance_2 + balace_2_auto < ' . Balances::AUTO_CREDIT_AMOUNT)
            ->chunk(100, function ($creators) {
                foreach ($creators as $creator) {
                    $this->balancesService->autoCreditMoney($creator);
                }
            });
    }
}
