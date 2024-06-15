<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ads\UpdateOptionsRequest;
use App\Models\Option;

class UpdateOptionsController extends Controller
{
    public function __invoke(UpdateOptionsRequest $request)
    {
        Option::updateOrCreate(
            ['name' => 'ad_options',], 
            ['value' => json_encode($request->validated()),]
        );

        return response(['message' => 'OK',]);
    }
}
