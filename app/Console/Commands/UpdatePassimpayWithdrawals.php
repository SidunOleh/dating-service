<?php

namespace App\Console\Commands;

use App\Constants\Transactions;
use App\Models\PassimpayWithdrawal;
use App\Models\Transaction;
use App\Services\Balances\BalancesService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UpdatePassimpayWithdrawals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passimpay:update-withdrawals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update passimpay withdrawals';

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
        Transaction::where([
            'details_type' => PassimpayWithdrawal::class,
            'status' => Transactions::PASSIMPAY_WITHDRAWAL_STATUS['pending'],
        ])->chunk(1000, [$this, 'update']);
    }

    public function update(Collection $transactions)
    {
        foreach ($transactions as $transaction) {
            try {
                $this->balancesService->updateWithdrawalStatus($transaction->creator, $transaction);
            } catch (Exception $e) {                
                Log::error($e, ['transaction_id' => $transaction->id,]);
            }
        }
    }
}
