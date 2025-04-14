<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\SwitchOptionRequest;
use Illuminate\Support\Facades\Auth;

class SwitchOptionController extends Controller
{
    public function __invoke(SwitchOptionRequest $request)
    {
        $creator = Auth::guard('web')->user();

        $creator->update([$request->name => $request->value]);

        return response(['message' => 'OK',]);
    }
}
