<?php

namespace App\Listeners;

use App\Models\Option;
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
                        
            $amount = $settings['subscription_price'] * $settings['referral_percent'] / 100;

            $creator->referral->reward($amount);
        }
    }
}
