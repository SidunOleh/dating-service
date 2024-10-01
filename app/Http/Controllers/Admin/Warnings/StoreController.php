<?php

namespace App\Http\Controllers\Admin\Warnings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Warnings\StoreRequest;
use App\Models\Warning;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        Warning::create($request->validated());

        return response(['message' => 'OK',]);
    }
}
