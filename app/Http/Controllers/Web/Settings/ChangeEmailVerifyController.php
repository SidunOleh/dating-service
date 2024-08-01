<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailVerifyRequest;
use App\Services\VerificationCode;
use Exception;
use Illuminate\Support\Facades\Auth;

class ChangeEmailVerifyController extends Controller
{
    public function __invoke(ChangeEmailVerifyRequest $request)
    {
        try {
            $code = new VerificationCode('change_email');
            $code->verify($request->input('code'));

            $data = $code->data();

            $creator = Auth::guard('web')->user();
            $creator->email = $data['new_email'];
            $creator->save();

            $code->forget();

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
