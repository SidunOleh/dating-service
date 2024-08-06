<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        $transactions = $creator
            ->transactions()
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('pages.subscription', [
            'creator' => $creator,
            'transactions' => $transactions,
        ]);
    }
}
