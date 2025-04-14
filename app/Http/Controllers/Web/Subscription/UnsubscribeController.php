<?php

namespace App\Http\Controllers\Web\Subscription;

use App\Exceptions\HasNotSubscriptionException;
use App\Http\Controllers\Controller;
use App\Services\Subscriptions\SubscriptionsService;
use Illuminate\Support\Facades\Auth;

class UnsubscribeController extends Controller
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

            $this->subscriptionsService->unsubscribe($creator);
    
            return response(['message' => 'OK',]);
        } catch (HasNotSubscriptionException $e) {
            return response(['message' => 'You are not subscribed.',]);
        }
    }
}
