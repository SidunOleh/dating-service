<?php

namespace App\Http\Controllers\Admin\Warnings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Warnings\UpdateRequest;
use App\Models\Warning;

class UpdateController extends Controller
{
    public function __invoke(Warning $warning, UpdateRequest $request)
    {
        $warning->update($request->validated());

        return response(['message' => 'OK',]);
    }
}
