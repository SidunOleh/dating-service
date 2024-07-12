<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        return view('pages.my-profile.edit', [
            'creator' => $creator,
        ]);
    }
}
