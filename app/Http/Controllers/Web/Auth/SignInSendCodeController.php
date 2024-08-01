<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInSendCodeRequest;
use App\Services\VerificationCode;
use Illuminate\Support\Facades\Auth;

class SignInSendCodeController extends Controller
{
    public function __invoke(SignInSendCodeRequest $request)
    {
        $credentials = $request->only(['email', 'password',]);

        if (! Auth::guard('web')->validate($credentials)) {
            return response(['message' => 'Wrong credentials.',], 401);
        }

        $code = VerificationCode::create('signin', $credentials);
        $code->send($credentials['email']);

        return response(['message' => 'OK',]);
    }
}
