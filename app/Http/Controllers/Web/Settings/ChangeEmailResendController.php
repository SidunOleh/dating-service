<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailResendRequest;
use App\Services\VerificationCode;
use Exception;
use Illuminate\Support\Facades\Auth;

class ChangeEmailResendController extends Controller
{
    public function __invoke(ChangeEmailResendRequest $request)
    {
        try {
            $code = new VerificationCode('change_email');
            $code->resend(Auth::guard('web')->user()->email);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
