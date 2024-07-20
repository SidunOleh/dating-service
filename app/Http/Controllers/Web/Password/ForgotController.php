<?php

namespace App\Http\Controllers\Web\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Password\ForgotRequest;
use Illuminate\Support\Facades\Password;

class ForgotController extends Controller
{
    public function __invoke(ForgotRequest $request)
    {
        $status = Password::broker('creators')->sendResetLink($request->only('email'));

        return response(['message' =>__($status),], $status == Password::RESET_LINK_SENT ? 200 : 400);
    }
}
