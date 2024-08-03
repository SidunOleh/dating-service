<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInVerifyCodeRequest;
use App\Services\Verification\Code;
use Exception;
use Illuminate\Support\Facades\Auth;

class SignInVerifyCodeController extends Controller
{
    public function __invoke(SignInVerifyCodeRequest $request)
    {
        try {
            $code = new Code('signin');
            $code->verify($request->input('code'));

            $credentials = $code->data();

            if (! Auth::guard('web')->attempt($credentials)) {
                return response(['message' => 'Wrong credentials.',], 401);
            }

            $code->forget();

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
