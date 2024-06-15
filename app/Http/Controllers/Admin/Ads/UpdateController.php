<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ads\UpdateRequest;
use App\Models\Ad;

class UpdateController extends Controller
{
    public function __invoke(Ad $ad, UpdateRequest $request)
    {
        $ad->update($request->validated());

        return response(['message' => 'OK',]);
    }
}
