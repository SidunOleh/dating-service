<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Creator\EditCreatorData;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return redirect()->route('my-profile.create');
        }

        if ($creator->hasUndoneProfileRequest()) {
            return redirect()->route('my-profile.show');
        }

        return view('pages.my-profile.edit', [
            'creator' => $creator,
            'data' => new EditCreatorData($creator),
        ]);
    }
}
