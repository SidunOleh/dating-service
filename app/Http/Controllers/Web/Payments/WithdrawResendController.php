<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\WithdrawResendRequest;
use App\Services\Verification\Code;
use Exception;
use Illuminate\Support\Facades\Auth;

class WithdrawResendController extends Controller
{
    public function __invoke(WithdrawResendRequest $request)
    {
        try {
            $code = new Code('withdraw');
            $code->resend(Auth::guard('web')->user()->email);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => 'Bad request',], 400);
        }
    }
}
