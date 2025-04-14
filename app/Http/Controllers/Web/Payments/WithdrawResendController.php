<?php

namespace App\Http\Controllers\Web\Payments;

use App\Exceptions\TooFastException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\WithdrawResendRequest;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Auth;

class WithdrawResendController extends Controller
{
    public function __invoke(WithdrawResendRequest $request)
    {
        try {
            $code = new Code('withdraw');
            $code->resend(Auth::guard('web')->user()->email);

            return response(['message' => 'OK',]);
        } catch (TooFastException $e) {
            return response(['message' => 'Too fast.',], 400);
        }
    }
}
