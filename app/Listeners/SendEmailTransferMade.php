<?php

namespace App\Listeners;

use App\Events\TransferMade as EventsTransferMade;
use App\Notifications\TransferMade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailTransferMade
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
    public function handle(EventsTransferMade $event): void
    {
        $event->creator->notify(new TransferMade($event->creator));
    }
}
