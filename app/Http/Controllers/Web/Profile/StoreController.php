<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\StoreRequest;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $requets)
    {
        $creator = Auth::guard('web')->user();

        if ($creator->profile_is_created) {
            return abort(400);
        }

        $creator->createProfileRequest($requets->validated());
        
        $creator->profile_is_created = true;
        $creator->save();

        return response(['message' => 'OK',]);
    }
}
