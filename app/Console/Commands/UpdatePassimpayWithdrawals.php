<?php

namespace App\Console\Commands;

use App\Models\PassimpayWithdrawal;
use App\Models\Transaction;
use App\Services\PaymentGateways\Passimpay\PassimpayApi;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Transaction::where([
            'details_type' => PassimpayWithdrawal::class,
            'status' => 'pending',
        ])->chunk(1000, [$this, 'update']);
    }

    public function update(Collection $transactions)
    {
        $passimpay = new PassimpayApi(
            config('services.passimpay.platform_id'),
            config('services.passimpay.secret_key')
        );

        $status = [
            'pending',
            'success',
            'error',
        ];
        foreach ($transactions as $transaction) {
            try {
                $response = $passimpay->withdrawstatus(
                    $transaction->details->transaction_id
                );

                DB::beginTransaction();

                $transaction->update([
                    'status' => $status[$response['approve']],
                ]);

                if ($response['approve'] == 2) {
                    $transaction->creator->balance += $transaction->amount;
                    $transaction->creator->save();
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                
                Log::error($e, ['passimpay_withdrawal_id' => $transaction->details->id,]);
            }
        }
    }
}
