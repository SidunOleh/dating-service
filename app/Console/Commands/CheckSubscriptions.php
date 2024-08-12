<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Subscription::where('status', 'active')
            ->whereRaw('DATE(ends_at) <= "' . now()->format('Y-m-d') . '"')
            ->chunk(1000, [$this, 'check']);
    }

    public function check(Collection $subscriptions): void
    {
        foreach ($subscriptions as $subscription) {
            try {
                $subscription->inactivate();

                if (
                    ! $subscription->unsubscribed and 
                    $subscription->creator->hasEnoughMoney(Subscription::PRICE)
                ) {
                    $subscription->creator->subscribe();
                }
            } catch (Exception $e) {
                Log::error($e, [
                    'subscription_id' => $subscription->id,
                ]);
            }
        }
    }
}
