<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Models\Option;

class TopVoteController extends Controller
{
    public function __invoke()
    {
        $roulette = Creator::roulettePair();
        $topVote = Creator::topVote(100);

        $settings = Option::getSettings();

        return view('pages.top-vote', [
            'roulette' => $roulette,
            'topVote' => $topVote,
            'settings' => $settings,
        ]);
    }
}
