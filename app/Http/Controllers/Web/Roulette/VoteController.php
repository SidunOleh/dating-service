<?php

namespace App\Http\Controllers\Web\Roulette;

use App\Http\Controllers\Controller;
use App\Models\Creator;

class VoteController extends Controller
{
    public function __invoke(Creator $creator)
    {
        $creator->votes += 1;
        $creator->save();

        return response(['message' => 'OK',]);
    }
}
