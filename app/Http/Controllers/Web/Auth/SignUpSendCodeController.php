<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpSendCodeRequest;
use App\Models\Creator;
use App\Notifications\VerificationCode;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;

class SignUpSendCodeController extends Controller
{
    public function __invoke(SignUpSendCodeRequest $request)
    {
        $credentials = $request->except('recaptcha');

        $code = Creator::makeVerificationCode();

        session(['signup' => [
            'code' => $code,
            'created_at' => time(),
            'expire_at' => time() + 60 * 10,
            'credentials' => $credentials,
            'attemps' => 0,
        ],]);

        Notification::route('mail', $credentials['email'])->notify(new VerificationCode($code));

        if ($from = $request->input('from')) {
            Cookie::queue('from', $from);
        }

        return response(['message' => 'OK',]);
    }
}
