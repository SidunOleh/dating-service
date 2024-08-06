<?php

namespace App\Providers;

use App\Events\CreatorInactivated;
use App\Events\CreatorSubscribed;
use App\Events\UserCreated;
use App\Events\WithdrawRequestRejected;
use App\Events\WithdrawRequestSuccess;
use App\Listeners\PayPercentReferrer;
use App\Listeners\SendEmailToInactivatedCreator;
use App\Listeners\SendEmailWithCredentialsToNewUser;
use App\Listeners\WithdrawRequestRejectedSendMail;
use App\Listeners\WithdrawRequestSuccessSendMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            SendEmailWithCredentialsToNewUser::class,
        ],
        CreatorInactivated::class => [
            SendEmailToInactivatedCreator::class,
        ],
        CreatorSubscribed::class => [
            PayPercentReferrer::class,
        ],
        WithdrawRequestSuccess::class => [
            WithdrawRequestSuccessSendMail::class,
        ],
        WithdrawRequestRejected::class => [
            WithdrawRequestRejectedSendMail::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
