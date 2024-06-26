<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Notifications\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SignInResendCodeController extends Controller
{
    public function __invoke()
    {
        if (! $signin = session('signin')) {
            return response(['message' => 'Bad request.',], 400);
        }

        if ($signin['retry'] + 1 > 5) {
            return response(['message' => 'Too many attemps.',], 429);
        }

        if (now()->lessThan(Carbon::createFromTimestamp($signin['created_at'] + 60))) {
            return response(['message' => 'Too fast.',], 400);
        }

        $signin['code'] = Creator::makeVerificationCode();
        $signin['created_at'] = time();
        $signin['expire_at'] = time() + 60 * 10;
        $signin['try'] = 0;
        $signin['retry'] += 1;

        session(['signin' => $signin,]);

        Notification::route('mail', $signin['credentials']['email'])->notify(new VerificationCode($signin['code']));

        return response(['message' => 'OK',]);
    }
}
