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
        $code = Code::create('withdraw', $request->validated());
        $code->send(Auth::guard('web')->user()->email);

        return response(['message' => 'OK',]);
    }
}
