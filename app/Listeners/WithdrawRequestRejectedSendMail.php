<?php

namespace App\Listeners;

use App\Notifications\WithdrawRequestRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WithdrawRequestRejectedSendMail
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
        $event->withdrawalRequest->creator->notify(new WithdrawRequestRejected($event->withdrawalRequest));
    }
}
