<?php

namespace App\Http\Controllers\Web\Settings;

use App\Exceptions\CodeIsExpiredException;
use App\Exceptions\InvalidCodeException;
use App\Exceptions\TooManyAttempsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailVerifyRequest;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Auth;

class ChangeEmailVerifyController extends Controller
{
    public function __invoke(ChangeEmailVerifyRequest $request)
    {
        try {
            $code = new Code('change_email');
            $code->verify($request->input('code'));

            $data = $code->data();

            $creator = Auth::guard('web')->user();

            $creator->update(['email' => $data['new_email']]);

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
