<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\SendResetLinkReqest;
use Illuminate\Support\Facades\Password;

class SendResetLink extends Controller
{
    public function __invoke(SendResetLinkReqest $request)
    {
        $status = Password::sendResetLink($request->validated());

        return response(['message' =>__($status),], $status == Password::RESET_LINK_SENT ? 200 : 400);
    }
}
