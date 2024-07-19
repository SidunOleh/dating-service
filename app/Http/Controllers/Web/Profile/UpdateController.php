<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\UpdateRequest;
use App\Models\ZipCode;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $requets)
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return abort(400);
        }

        if ($creator->hasUndoneProfileRequest()) {
            return abort(400);
        }

        $validated = $requets->validated();

        $zip = ZipCode::firstWhere('zip', $validated['zip']);
        $validated['state'] = $zip['state'];
        $validated['city'] = $zip['city'];

        $creator->saveNotApprovableProfileChanges($validated);
        $creator->createProfileRequest($validated);

        return response(['message' => 'OK',]);
    }
}
