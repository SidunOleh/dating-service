<?php

namespace App\Console\Commands;

use App\Constants\Transactions;
use App\Models\PlisioWithdrawal;
use App\Services\Balances\BalancesService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UpdatePlisioWithdrawals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plisio:update-withdrawals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update plisio withdrawals';

    public function __construct(
        public BalancesService $balancesService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PlisioWithdrawal::where([
            'status' => Transactions::PLISIO_WITHDRAWAL_STATUS['pending'],
        ])->chunk(1000, [$this, 'update']);
    }

    public function update(Collection $withdrawals)
    {
        foreach ($withdrawals as $withdrawal) {
            try {
                $this->balancesService->updateWithdrawalStatus(
                    $withdrawal->transaction->creator,
                    $withdrawal->transaction,
                );
            } catch (Exception $e) {
                Log::error($e, ['transaction_id' => $withdrawal->transaction->id,]);
            }
        }
    }
}
