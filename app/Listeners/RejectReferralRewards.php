<?php

namespace App\Listeners;

use App\Constants\Referral;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RejectReferralRewards
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
        $event->creator->referralRewards()
            ->where('status', Referral::REWARD_STATUS['pending'])
            ->update(['status' => Referral::REWARD_STATUS['rejected']]);
    }
}
