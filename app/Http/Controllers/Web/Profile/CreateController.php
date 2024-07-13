<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        // if ($creator->profile_is_created) {
        //     return redirect()->route('my-profile.show');
        // }

        return view('pages.my-profile.create', [
            'creator' => $creator,
        ]);
    }
}
