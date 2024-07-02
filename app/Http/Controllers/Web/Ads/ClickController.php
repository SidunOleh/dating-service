<?php

namespace App\Http\Controllers\Web\Ads;

use App\Http\Controllers\Controller;
use App\Models\Ad;

class ClickController extends Controller
{
    public function __invoke(Ad $ad)
    {
        $ad->clicks_count += 1;
        $ad->save();

        return response(['message' => 'OK',]);
    }
}
