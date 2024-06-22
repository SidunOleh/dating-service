<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Notifications\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SignUpResendCodeController extends Controller
{
    public function __invoke()
    {
        if (
            ! $signup = session('signup') or
            now()->lessThan(Carbon::createFromTimestamp($signup['created_at'] + 60))
        ) {
            return response(['message' => 'Bad Request',], 400);
        }

        $signup['code'] = Creator::makeVerificationCode();
        $signup['created_at'] = time();
        $signup['expire_at'] = time() + 60 * 10;

        session(['signup' => $signup,]);

        Notification::route('mail', $signup['credentials']['email'])->notify(new VerificationCode($signup['code']));

        return response(['message' => 'OK',]);
    }
}
