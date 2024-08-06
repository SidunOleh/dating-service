<?php

namespace App\Http\Controllers\Web\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if ($creator->activeSub) {
            abort(400);
        }

        $subscription = $creator->subscribe();

        return response($subscription);
    }
}
