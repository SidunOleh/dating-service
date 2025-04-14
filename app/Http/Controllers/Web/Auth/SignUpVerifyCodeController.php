<?php

namespace App\Http\Controllers\Web\Auth;

use App\Exceptions\CodeIsExpiredException;
use App\Exceptions\InvalidCodeException;
use App\Exceptions\TooManyAttempsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpVerifyCodeRequest;
use App\Models\Creator;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Auth;

class SignUpVerifyCodeController extends Controller
{
    public function __invoke(SignUpVerifyCodeRequest $request)
    {
        try {
            $code = new Code('signup');
            $code->verify($request->input('code'));

            $credentials = $code->data();

            $creator = Creator::create($credentials);

            Auth::guard('web')->login($creator);

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
