<?php

namespace App\Http\Controllers\Web\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UnsubscribeController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->activeSub) {
            abort(400);
        }

        $creator->unsubscribe();

        return response(['message' => 'OK',]);
    }
}
