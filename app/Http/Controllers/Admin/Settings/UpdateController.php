<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateRequest;
use App\Models\Option;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request)
    {
        Option::updateSettings($request->validated());

        return response(['message' => 'OK',]);
    }
}
