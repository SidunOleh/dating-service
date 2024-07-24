<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;

class TopVoteController extends Controller
{
    public function __invoke()
    {
        $topVote = Creator::topVote(100);
        $roulette = Creator::roulettePair();

        return view('pages.top-vote', [
            'topVote' => $topVote,
            'roulette' => $roulette,
        ]);
    }
}
