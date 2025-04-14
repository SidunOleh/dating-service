<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Services\Creators\CreatorsService;
use Illuminate\Support\Facades\Auth;

class TopVoteController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService
    )
    {
        
    }

    public function __invoke()
    {
        $roulette = $this->creatorsService->roulettePair([Auth::guard('web')->id()]);
        $topVote = $this->creatorsService->topVote(100);

        $settings = Option::getSettings();

        return view('pages.top-vote', [
            'roulette' => $roulette,
            'topVote' => $topVote,
            'settings' => $settings,
        ]);
    }
}
