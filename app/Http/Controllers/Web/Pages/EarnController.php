<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class EarnController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        $referrals = $creator
            ->referrals()
            ->with('referee')
            ->orderBy('created_at', 'DESC')
            ->get();
        $transactions = $creator
            ->transactions()
            ->orderBy('created_at', 'DESC')
            ->get();
        $percent = (int) Option::getOption('referral_percent', 0);

        return view('pages.earn', [
            'creator' => $creator,
            'referrals' => $referrals,
            'transactions' => $transactions,
            'percent' => $percent,
        ]);
    }
}
