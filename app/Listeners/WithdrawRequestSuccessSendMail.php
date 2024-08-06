<?php

namespace App\Listeners;

use App\Notifications\WithdrawRequestSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WithdrawRequestSuccessSendMail
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
        $event->withdrawalRequest->creator->notify(new WithdrawRequestSuccess($event->withdrawalRequest));
    }
}
