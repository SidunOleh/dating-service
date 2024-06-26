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
        if (! $signup = session('signup')) {
            return response(['message' => 'Bad request.',], 400);
        }

        if ($signup['retry'] + 1 > 5) {
            return response(['message' => 'Too many attemps.',], 429);
        }

        if (now()->lessThan(Carbon::createFromTimestamp($signup['created_at'] + 60))) {
            return response(['message' => 'Too fast.',], 400);
        }

        $signup['code'] = Creator::makeVerificationCode();
        $signup['created_at'] = time();
        $signup['expire_at'] = time() + 60 * 10;
        $signup['try'] = 0;
        $signup['retry'] += 1;

        session(['signup' => $signup,]);

        Notification::route('mail', $signup['credentials']['email'])->notify(new VerificationCode($signup['code']));

        return response(['message' => 'OK',]);
    }
}
