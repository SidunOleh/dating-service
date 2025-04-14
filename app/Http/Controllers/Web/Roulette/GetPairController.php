<?php

namespace App\Http\Controllers\Web\Roulette;

use App\Http\Controllers\Controller;
use App\Services\Creators\CreatorsService;
use Illuminate\Support\Facades\Auth;

class GetPairController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService
    )
    {
        
    }

    public function __invoke()
    {
        $pair = $this->creatorsService->roulettePair([Auth::guard('web')->id()]);

        if ($pair->count() < 2) {
            return response('', 204);
        }

        return response(['pair' => $pair,]);
    }
}
