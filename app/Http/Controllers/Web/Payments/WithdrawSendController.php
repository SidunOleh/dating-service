<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\WithdrawSendRequest;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Auth;

class WithdrawSendController extends Controller
{
    public function __invoke(WithdrawSendRequest $request)
    {
        $creator = Auth::guard('web')->user();

        if ($creator->withdrawalRequestInPending) {
            return response(['message' => 'Wait until prev withdrawal will be completed.'], 400);
        }

        $code = Code::create('withdraw', $request->validated());
        $code->send($creator->email);

        return response(['message' => 'OK',]);
    }
}
