<?php

namespace App\Http\Controllers\Web\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\DepositRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    public function __invoke(DepositRequest $request)
    {
        $vaidated = $request->validated();

        try {
            $transaction = Auth::guard('web')->user()->deposit(
                $vaidated['gateway'], 
                $vaidated['amount'], 
                $vaidated
            );
            $transaction->details;

            return response($transaction);
        } catch (Exception $e) {
            Log::error($e, [
                'creator_id' => Auth::guard('web')->id(),
            ]);

            return response(['message' => 'Bad request',], 400);
        }
    }
}
