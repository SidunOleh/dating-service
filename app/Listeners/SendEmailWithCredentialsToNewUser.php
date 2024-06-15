<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Notifications\NewUserCredentials;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailWithCredentialsToNewUser
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
    public function handle(UserCreated $event): void
    {
        $event->user->notify(new NewUserCredentials($event->user, $event->password));
    }
}
