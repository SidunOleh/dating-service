<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        $settings = Option::getSettings();

        $transactionsList = $this->balancesService->getTransactionList($creator);

        return view('pages.subscription', [
            'creator' => $creator,
            'price' => $settings['subscription_price'],
            'transactionsList' => $transactionsList,
        ]);
    }
}
