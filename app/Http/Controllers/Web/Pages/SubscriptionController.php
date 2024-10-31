<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        $settings = Option::getSettings();

        return view('pages.subscription', [
            'creator' => $creator,
            'price' => $settings['subscription_price'],
        ]);
    }
}
