<?php

namespace App\Http\Controllers\Web\Subscription;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Services\Subscriptions\SubscriptionsService;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function __construct(
        public SubscriptionsService $subscriptionsService
    )
    {
        
    }

    public function __invoke()
    {
        try {
            $creator = Auth::guard('web')->user();

            $subscription = $this->subscriptionsService->subscribe($creator);

            return response($subscription);
        } catch (NotEnoughMoneyException $e) {
            return response(['message' => 'Balance is too low!',], 400);
        }
    }
}
