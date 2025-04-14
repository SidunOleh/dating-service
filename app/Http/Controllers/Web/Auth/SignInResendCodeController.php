<?php

namespace App\Http\Controllers\Web\Auth;

use App\Exceptions\TooFastException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInResendCodeRequest;
use App\Services\Verification\Code;

class SignInResendCodeController extends Controller
{
    public function __invoke(SignInResendCodeRequest $request)
    {
        try {
            $code = new Code('signin');

            $credentials = $code->data();

            $code->resend($credentials['email']);

            return response(['message' => 'OK',]);
        } catch (TooFastException $e) {
            return response(['message' => 'Too fast.',], 400);
        }
    }
}
