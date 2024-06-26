<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpSendCodeRequest;
use App\Models\Creator;
use App\Notifications\VerificationCode;
use Illuminate\Support\Facades\Notification;

class SignUpSendCodeController extends Controller
{
    public function __invoke(SignUpSendCodeRequest $request)
    {
        $credentials = $request->validated();

        $code = Creator::makeVerificationCode();

        session(['signup' => [
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
