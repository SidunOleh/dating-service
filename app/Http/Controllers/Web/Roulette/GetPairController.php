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
        $except = [];
        if (Auth::guard('web')->check()) {
            $except[] = Auth::guard('web')->id();
        }

        $pair = $this->creatorsService->roulettePair($except);

        if ($pair->count() < 2) {
            return response('', 204);
        }

        return response(['pair' => $pair,]);
    }
}
