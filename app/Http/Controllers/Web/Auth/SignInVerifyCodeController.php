<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInVerifyCodeRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SignInVerifyCodeController extends Controller
{
    public function __invoke(SignInVerifyCodeRequest $request)
    {
        $code = $request->input('code');

        if (! $signin = session('signin')) {
            return response(['message' => 'Bad request.',], 400);
        }

        session(['signin.attemps' => ++$signin['attemps'],]);

        if ($signin['attemps'] > config('auth.attemps.verify')) {
            return response(['message' => 'Too many attemps.',], 429);
        }

        if ($signin['code'] != $code) {
            return response(['message' => 'Invalid verification code.',], 400);
        }

        if (now()->greaterThan(Carbon::createFromTimestamp($signin['expire_at']))) {
            return response(['message' => 'Verification code is expired.',], 400);
        }

        if (! Auth::guard('web')->attempt(session('signin.credentials'))) {
            return response(['message' => 'Wrong credentials.',], 401);
        }

        session()->forget('signin');

        return response(['message' => 'OK',]);
    }
}
