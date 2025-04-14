<?php

namespace App\Http\Controllers\Web\Auth;

use App\Exceptions\TooFastException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpResendCodeRequest;
use App\Services\Verification\Code;

class SignUpResendCodeController extends Controller
{
    public function __invoke(SignUpResendCodeRequest $request)
    {
        try {
            $code = new Code('signup');

            $credentials = $code->data();

            $code->resend($credentials['email']);

            return response(['message' => 'OK',]);
        } catch (TooFastException $e) {
            return response(['message' => 'Too fast.',], 400);
        }
    }
}
