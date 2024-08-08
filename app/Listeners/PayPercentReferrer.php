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
            $settings = Option::getSettings();
                        
            $amount = Subscription::PRICE * $settings['referral_percent'] / 100;

            $creator->referral->reward($amount);
        }
    }
}
