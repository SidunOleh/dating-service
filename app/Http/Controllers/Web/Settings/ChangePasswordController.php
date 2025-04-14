<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request)
    {
        $creator = Auth::guard('web')->user();

        $creator->update(['password' => $request->input('new_password')]);

        return response(['message' => 'OK',]);
    }
}
