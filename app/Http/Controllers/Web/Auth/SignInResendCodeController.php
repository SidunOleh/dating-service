<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInResendCodeRequest;
use App\Services\VerificationCode;
use Exception;

class SignInResendCodeController extends Controller
{
    public function __invoke(SignInResendCodeRequest $request)
    {
        try {
            $code = new VerificationCode('signin');

            $credentials = $code->data();

            $code->resend($credentials['email']);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
