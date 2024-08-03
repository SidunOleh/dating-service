<?php

namespace App\Http\Controllers\Web\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if ($creator->activeSubscription) {
            abort(400);
        }

        $creator->subscribe();

        return response(['message' => 'OK',]);
    }
}
