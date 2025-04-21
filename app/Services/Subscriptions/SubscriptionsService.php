<?php

namespace App\Services\Subscriptions;

use App\Constants\Subscriptions;
use App\Events\CreatorSubscribed;
use App\Exceptions\HasNotSubscriptionException;
use App\Exceptions\HasSubscriptionException;
use App\Exceptions\NotEnoughMoneyException;
use App\Exceptions\SubscriptionIsInactiveException;
use App\Models\Creator;
use App\Models\Option;
use App\Models\Subscription;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\DB;

class SubscriptionsService
{
    public function __construct(
        private BalancesService $balancesService
    )
    {
        
    }

    public function subscribe(Creator $creator): Subscription
    {
        if ($creator->activeSub) {
            throw new HasSubscriptionException();
        }

        $settings = Option::getSettings();

        if (! $creator->hasEnoughMoney($settings['subscription_price'])) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $creator->debitMoney($settings['subscription_price']);

        $subscription = Subscription::create([
            'status' => Subscriptions::STATUS['active'],
            'starts_at' => now(),
            'ends_at' => now()->addMonths(Subscriptions::DURATION_IN_MONTHS),
            'creator_id' => $creator->id,
        ]);

        DB::commit();

        CreatorSubscribed::dispatch($creator, $subscription);

        return $subscription;
    }

    public function unsubscribe(Creator $creator): void
    {
        if (! $creator->activeSub) {
            throw new HasNotSubscriptionException();
        }

        $creator->activeSub->update(['unsubscribed' => true]);
    }

    public function check(Subscription $subscription): void
    {
        if ($subscription->status != Subscriptions::STATUS['active']) {
            throw new SubscriptionIsInactiveException();
        }

        if ($subscription->ends_at->gt(now())) {
            return;
        }

        $subscription->update(['status' => Subscriptions::STATUS['inactive']]);

        if (! $subscription->unsubscribed) {
            $this->subscribe($subscription->creator);
        }
    }
}