<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpVerifyCodeRequest;
use App\Models\Creator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SignUpVerifyCodeController extends Controller
{
    public function __invoke(SignUpVerifyCodeRequest $request)
    {
        $code = $request->input('code');

        if (! $signup = session('signup')) {
            return response(['message' => 'Bad request.',], 400);
        }
        
        session(['signup.attemps' => ++$signup['try'],]);

        if ($signup['attemps'] > 10) {
            return response(['message' => 'Too many attemps.',], 429);
        }

        if ($signup['code'] != $code) {
            return response(['message' => 'Invalid verification code.',], 400);
        }

        if (now()->greaterThan(Carbon::createFromTimestamp($signup['expire_at']))) {
            return response(['message' => 'Verification code is expired.',], 400);
        }

        $creator = Creator::create(session('signup.credentials'));

        Auth::guard('web')->login($creator);

        session()->forget('signup');

        return response(['message' => 'OK',]);
    }
}
