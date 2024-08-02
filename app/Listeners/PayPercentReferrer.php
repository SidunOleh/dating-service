<?php

namespace App\Listeners;

use App\Models\Option;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PayPercentReferrer
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $creator = $event->creator;
        
        if ($creator->referral and ! $creator->referral->rewarded()) {
            $percent = (int) Option::getOption('referral_percent', 0);

            $creator->referral->reward(Subscription::PRICE * $percent / 100);
        }
    }
}
