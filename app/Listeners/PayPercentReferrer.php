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
            $settings = json_decode(Option::getOption('settings'), true);
            $percent = $settings['referral_percent'] ?? 0;
            
            $amount = Subscription::PRICE * $percent / 100;

            $creator->referral->reward($amount);
        }
    }
}
