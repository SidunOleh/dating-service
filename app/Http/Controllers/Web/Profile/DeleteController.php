<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return abort(400);
        }

        $creator->deleteProfile();

        return response(['message' => 'OK',]);
    }
}
