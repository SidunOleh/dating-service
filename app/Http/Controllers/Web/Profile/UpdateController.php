<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\UpdateRequest;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $requets)
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return abort(400);
        }

        if ($creator->profileRequests()->where('status', 'undone')->count()) {
            return abort(400);
        }

        $validated = $requets->validated();

        $creator->updateWithoutRequest($validated);
        $creator->createProfileRequest($validated);

        return response(['message' => 'OK',]);
    }
}
