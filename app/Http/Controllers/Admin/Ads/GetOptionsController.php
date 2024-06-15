<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Models\Option;
use stdClass;

class GetOptionsController extends Controller
{
    public function __invoke()
    {
        $options = Option::where('name', 'ad_options')->first();

        $options = json_decode($options?->value) ?? new stdClass;

        return response()->json($options);
    }
}
