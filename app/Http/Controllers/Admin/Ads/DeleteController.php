<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Models\Ad;

class DeleteController extends Controller
{
    public function __invoke(Ad $ad)
    {
        $ad->delete();

        return response(['message' => 'OK',]);
    }
}
