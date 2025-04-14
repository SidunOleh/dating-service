<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Services\Balances\BalancesService;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }


    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        $transfersStat = [];
        $transfersStat['day'] = 
            $this->balancesService->balanceBalace2TransfersStat($creator, 'day');
        $transfersStat['week'] = 
            $this->balancesService->balanceBalace2TransfersStat($creator, 'week');
        $transfersStat['month'] = 
            $this->balancesService->balanceBalace2TransfersStat($creator, 'month');

        return view('pages.info', [
            'creator' => $creator,
            'transfersStat' => $transfersStat,
        ]);
    }
}
