<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\StoreRequest;
use App\Models\ZipCode;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $requets)
    {
        $creator = Auth::guard('web')->user();

        if ($creator->profile_is_created) {
            return abort(400);
        }

        $validated = $requets->validated();

        $zip = ZipCode::firstWhere('zip', $validated['zip']);
        $validated['state'] = $zip->state;
        $validated['city'] = $zip->city;

        $creator->createProfileRequest($validated);
        
        $creator->profile_is_created = true;
        $creator->save();

        return response(['message' => 'OK',]);
    }
}
