<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpResendCodeRequest;
use App\Models\Creator;
use App\Notifications\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SignUpResendCodeController extends Controller
{
    public function __invoke(SignUpResendCodeRequest $request)
    {
        if (! $signup = session('signup')) {
            return response(['message' => 'Bad request.',], 400);
        }

        if (now()->lessThan(Carbon::createFromTimestamp($signup['created_at'] + 60))) {
            return response(['message' => 'Too fast.',], 400);
        }

        $signup['code'] = Creator::makeVerificationCode();
        $signup['created_at'] = time();
        $signup['expire_at'] = time() + 60 * 10;
        $signup['attemps'] = 0;

        session(['signup' => $signup,]);

        Notification::route('mail', $signup['credentials']['email'])->notify(new VerificationCode($signup['code']));

        return response(['message' => 'OK',]);
    }
}
