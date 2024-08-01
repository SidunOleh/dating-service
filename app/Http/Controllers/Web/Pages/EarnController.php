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

        $percent = (int) Option::getOption('referral_percent', 0);

        return view('pages.earn', [
            'creator' => $creator,
            'percent' => $percent,
        ]);
    }
}
