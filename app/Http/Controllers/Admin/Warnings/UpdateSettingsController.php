<?php

namespace App\Http\Controllers\Admin\Warnings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Warnings\UpdateSettingsRequest;
use App\Models\Option;

class UpdateSettingsController extends Controller
{
    public function __invoke(UpdateSettingsRequest $request)
    {
        $settings = $request->validated();

        Option::updateSettings($settings);

        return response(['message' => 'OK',]);
    }
}
