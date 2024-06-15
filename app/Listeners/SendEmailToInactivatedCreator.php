<?php

namespace App\Listeners;

use App\Notifications\Inactivation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailToInactivatedCreator
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
        $event->creator->notify(new Inactivation($event->creator));
    }
}
