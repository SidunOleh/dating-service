<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ads\StoreRequest;
use App\Models\Ad;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        Ad::create($request->validated());

        return response(['message' => 'OK',]);
    }
}
