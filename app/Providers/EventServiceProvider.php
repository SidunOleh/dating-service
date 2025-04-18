<?php

namespace App\Providers;

use App\Events\CreatorInactivated;
use App\Events\CreatorSubscribed;
use App\Events\PostApproved;
use App\Events\PostRejected;
use App\Events\ProfileApproved;
use App\Events\TransferRequestApproved;
use App\Events\TransferRequestRejected;
use App\Events\UserCreated;
use App\Events\WithdrawRequestRejected;
use App\Events\WithdrawRequestSuccess;
use App\Listeners\PayPercentReferrer;
use App\Listeners\SendEmailPostApproved;
use App\Listeners\SendEmailPostRejected;
use App\Listeners\SendEmailProfileApproved;
use App\Listeners\SendEmailToInactivatedCreator;
use App\Listeners\SendEmailTransferApproved;
use App\Listeners\SendEmailTransferRejected;
use App\Listeners\SendEmailWithCredentialsToNewUser;
use App\Listeners\WithdrawRequestRejectedSendMail;
use App\Listeners\WithdrawRequestSuccessSendMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        ProfileApproved::class => [
            SendEmailProfileApproved::class,
        ],
        PostApproved::class => [
            SendEmailPostApproved::class,
        ],
        PostRejected::class => [
            SendEmailPostRejected::class,
        ],
        TransferRequestApproved::class => [
            SendEmailTransferApproved::class,
        ],
        TransferRequestRejected::class => [
            SendEmailTransferRejected::class,
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
