<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\DepositRequest;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function __invoke(DepositRequest $request)
    {
        $vaidated = $request->validated();

        $transaction = Auth::guard('web')->user()->deposit(
            $vaidated['gateway'], 
            $vaidated['amount'], 
            $vaidated
        );
        $transaction->details;

        return response(['transaction' => $transaction,]);
    }
}
