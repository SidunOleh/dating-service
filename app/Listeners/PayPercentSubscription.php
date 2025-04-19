<?php

namespace App\Listeners;

use App\Services\ReferralSystem\ReferralSystem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PayPercentSubscription implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public ReferralSystem $referralSystem
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $this->referralSystem->payPercentSubscription($event->creator);
    }
}
