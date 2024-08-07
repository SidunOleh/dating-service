<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creators\UpdateBalanceRequest;
use App\Models\Creator;

class UpdateBalanceController extends Controller
{
    public function __invoke(UpdateBalanceRequest $request, Creator $creator)
    {
        $creator->balance = $request->balance;
        $creator->save();

        return response(['message' => 'OK',]);
    }
}
