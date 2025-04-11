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

        $transferStat = [];
        $transferStat['day'] = $this->balancesService->transfersStat($creator, 'day');
        $transferStat['week'] = $this->balancesService->transfersStat($creator, 'week');
        $transferStat['month'] = $this->balancesService->transfersStat($creator, 'month');

        return view('pages.info', [
            'creator' => $creator,
            'transferStat' => $transferStat,
        ]);
    }
}
