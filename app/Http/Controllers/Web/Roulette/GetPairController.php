<?php

namespace App\Http\Controllers\Web\Roulette;

use App\Http\Controllers\Controller;
use App\Models\Creator;

class GetPairController extends Controller
{
    public function __invoke()
    {
        $pair = Creator::roulettePair();

        if ($pair->count() < 2) {
            return response('', 204);
        }

        return response(['pair' => $pair,]);
    }
}
