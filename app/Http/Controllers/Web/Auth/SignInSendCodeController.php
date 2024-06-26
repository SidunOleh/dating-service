<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInSendCodeRequest;
use App\Models\Creator;
use App\Notifications\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SignInSendCodeController extends Controller
{
    public function __invoke(SignInSendCodeRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::guard('web')->validate($credentials)) {
            return response(['message' => 'Wrong credentials.',], 401);
        }

        $code = Creator::makeVerificationCode();

        session(['signin' => [
            'code' => $code,
            'created_at' => time(),
            'expire_at' => time() + 60 * 10,
            'credentials' => $credentials,
            'try' => 0,
            'retry' => 0,
        ],]);

        Notification::route('mail', $credentials['email'])->notify(new VerificationCode($code));

        return response(['message' => 'OK',]);
    }
}
