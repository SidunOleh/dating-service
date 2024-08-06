<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\WithdrawVerifyRequest;
use App\Models\WithdrawalRequest;
use App\Services\Verification\Code;
use Exception;
use Illuminate\Support\Facades\Auth;

class WithdrawVerifyController extends Controller
{
    public function __invoke(WithdrawVerifyRequest $request)
    {
        try {
            $code = new Code('withdraw');
            $code->verify($request->input('code'));

            $data = $code->data();

            $creator = Auth::guard('web')->user();

            if (! $creator->hasEnoughMoney($data['amount'])) {
                return response(['message' => 'Not enough money on balance.',], 400);
            }
    
            WithdrawalRequest::createRequest($data);

            $code->forget();

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
