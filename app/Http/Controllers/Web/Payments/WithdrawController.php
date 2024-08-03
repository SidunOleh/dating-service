<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\WithdrawRequest;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function __invoke(WithdrawRequest $request)
    {
        $validated = $request->validated();

        $creator = Auth::guard('web')->user();

        if (! $creator->hasEnoughMoney($validated['amount'])) {
            return response(['message' => 'Not enough money on balance.',], 400);
        }

        WithdrawalRequest::createRequest($validated);

        return response(['message' => 'OK',]);
    }
}
