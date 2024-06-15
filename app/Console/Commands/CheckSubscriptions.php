<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

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
            ->chunk(1000, function (Collection $subscriptions) {
                foreach ($subscriptions as $subscription) {
                    if ($subscription->expired()) {
                        if (
                            $subscription->auto_resume and 
                            $subscription->creator->debitMoney(3)
                        ) {
                            $subscription->resume();
                        } else {
                            $subscription->cancel();
                        }
                    }
                }
            });
    }
}
