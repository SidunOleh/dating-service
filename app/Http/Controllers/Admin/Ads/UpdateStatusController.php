<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ads\UpdateStatusRequest;
use App\Models\Ad;

class UpdateStatusController extends Controller
{
    public function __invoke(Ad $ad, UpdateStatusRequest $request)
    {
        $ad->status = $request->input('status');
        $ad->save();

        return response(['message' => 'OK',]);
    }
}
