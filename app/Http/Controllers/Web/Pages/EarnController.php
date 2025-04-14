<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;

class EarnController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        $referrals = $creator
            ->referrals()
            ->with('referee')
            ->orderBy('created_at', 'DESC')
            ->get();
        $settings = Option::getSettings();

        $transactionsList = $this->balancesService->getTransactionList($creator);
        
        return view('pages.earn', [
            'creator' => $creator,
            'referrals' => $referrals,
            'settings' => $settings,
            'transactionsList' => $transactionsList,
        ]);
    }
}
