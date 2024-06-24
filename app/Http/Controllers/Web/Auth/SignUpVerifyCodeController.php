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

        if (
            session('signup.code') != $code or
            now()->greaterThan(Carbon::createFromTimestamp(session('signup.expire_at')))
        ) {
            return response(['message' => 'Bad Request',], 400);
        }

        $creator = Creator::create(session('signup.credentials'));

        Auth::guard('web')->login($creator);

        session()->forget('signup');

        return response(['message' => 'OK',]);
    }
}
