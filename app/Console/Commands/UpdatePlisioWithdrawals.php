<?php

namespace App\Console\Commands;

use App\Models\PlisioWithdrawal;
use App\Services\PaymentGateways\Plisio\Api\PlisioClient;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PlisioWithdrawal::where('status', 'pending')->chunk(1000, [$this, 'update']);
    }

    public function update(Collection $withdrawals)
    {
        $plisio = new PlisioClient(env('PLISIO_SECRET_KEY'));

        foreach ($withdrawals as $withdrawal) {
            try {
                $data = $plisio->transaction($withdrawal->plisio_id);

                $withdrawal->update([
                    'status' => $data['status'],
                ]);
                
                $withdrawal->transaction->update([
                    'status' => $data['status'],
                ]);
            } catch (Exception $e) {
                Log::error($e, [
                    'plisio_withdrawal_id' => $withdrawal->id,
                ]);
            }
        }
    }
}
