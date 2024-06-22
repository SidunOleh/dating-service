<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInVerifyCodeRequest;
use App\Models\Creator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SignInVerifyCodeController extends Controller
{
    public function __invoke(SignInVerifyCodeRequest $request)
    {
        $code = $request->input('code');

        if (
            session('signin.code') != $code or
            now()->greaterThan(Carbon::createFromTimestamp(session('signin.expire_at')))
        ) {
            return response(['message' => 'Bad Request',], 400);
        }

        if (! Auth::attempt(session('signin.credentials'))) {
            return response(['message' => 'Wrong credentials.',], 401);
        }

        session()->forget('signin');

        return response(['message' => 'OK',]);
    }
}
