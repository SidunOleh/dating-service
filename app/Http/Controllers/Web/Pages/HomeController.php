<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Models\PlisioWithdrawalRequest;
use App\Models\Template;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        // $template = Template::inRandomOrder()->firstOrFail();
        // $template->fillData(1);

        // dd($template->total(), ...$template->blocks);

        $plisioWithdrawalRequest = PlisioWithdrawalRequest::create([
            'to' => '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX71',
            'currency' => 'BTC',
        ]);

        $plisioWithdrawalRequest->common()->create([
            'gateway' => 'plisio',
            'usd_amount' => 100,
            'creator_id' => 1,
        ]);
    }
}
