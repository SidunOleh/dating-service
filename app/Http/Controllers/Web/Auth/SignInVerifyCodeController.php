<?php

namespace App\Http\Controllers\Web\Auth;

use App\Exceptions\CodeIsExpiredException;
use App\Exceptions\InvalidCodeException;
use App\Exceptions\TooManyAttempsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignInVerifyCodeRequest;
use App\Services\Verification\Code;
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
        } catch (TooManyAttempsException $e) {
            return response(['message' => 'Too many attemps.',], 400);
        } catch (CodeIsExpiredException $e) {
            return response(['message' => 'Code is expired.',], 400);
        } catch (InvalidCodeException $e) {
            return response(['message' => 'Invalid code.',], 400);
        }
    }
}
