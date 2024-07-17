<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return redirect()->route('my-profile.create');
        }

        if ($creator->profileRequests()->where('status', 'undone')->count()) {
            return redirect()->route('my-profile.show');
        }

        $request = $creator->latestProfileRequest;

        $data = $creator->latestProfileRequest->editFormData();

        return view('pages.my-profile.edit', [
            'creator' => $creator,
            'request' => $request,
            'data' => $data,
        ]);
    }
}
