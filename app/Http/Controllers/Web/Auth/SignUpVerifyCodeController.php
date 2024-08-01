<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpVerifyCodeRequest;
use App\Models\Creator;
use App\Services\VerificationCode;
use Exception;
use Illuminate\Support\Facades\Auth;

class SignUpVerifyCodeController extends Controller
{
    public function __invoke(SignUpVerifyCodeRequest $request)
    {
        try {
            $code = new VerificationCode('signup');
            $code->verify($request->input('code'));

            $credentials = $code->data();

            $creator = Creator::create($credentials);

            Auth::guard('web')->login($creator);

            $code->forget();

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
