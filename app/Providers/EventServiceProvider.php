<?php

namespace App\Providers;

use App\Events\BalanceEarnReset;
use App\Events\CreatorInactivated;
use App\Events\CreatorSubscribed;
use App\Events\PostApproved;
use App\Events\PostOpenDebitMoney;
use App\Events\PostRejected;
use App\Events\ProfileApproved;
use App\Events\TransferMade;
use App\Events\UserCreated;
use App\Events\WithdrawRequestRejected;
use App\Events\WithdrawRequestSuccess;
use App\Listeners\CompleteReferralRewards;
use App\Listeners\PayPercentPostOpen;
use App\Listeners\PayPercentSubscription;
use App\Listeners\RejectReferralRewards;
use App\Listeners\SendEmailPostApproved;
use App\Listeners\SendEmailPostRejected;
use App\Listeners\SendEmailProfileApproved;
use App\Listeners\SendEmailToInactivatedCreator;
use App\Listeners\SendEmailTransferMade;
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
            PayPercentSubscription::class,
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
        PostOpenDebitMoney::class => [
            PayPercentPostOpen::class,
        ],
        TransferMade::class => [
            SendEmailTransferMade::class,
            CompleteReferralRewards::class,
        ],
        BalanceEarnReset::class => [
            RejectReferralRewards::class,
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
