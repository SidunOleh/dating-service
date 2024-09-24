<?php

namespace App\Http\Controllers\Web\Subscription;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if ($creator->activeSub) {
            abort(400);
        }

        try {
            $subscription = $creator->subscribe();

            return response($subscription);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
