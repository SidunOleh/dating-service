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
        
        $creator->{$request->name} = $request->value;
        $creator->save();

        return response(['message' => 'OK',]);
    }
}
