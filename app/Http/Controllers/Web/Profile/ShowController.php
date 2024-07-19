<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return redirect()->route('my-profile.create');
        }

        $request = $creator->latestProfileRequest;

        $data = $request->profileData();

        return view('pages.my-profile.show', [
            'creator' => $creator,
            'request' => $request,
            'data' => $data,
        ]);
    }
}
