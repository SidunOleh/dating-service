<?php

namespace App\Http\Controllers\Web\Deposit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Deposit\PlisioRequest;
use App\Models\PlisioInvoice;

class PlisioController extends Controller
{
    public function __invoke(PlisioRequest $request)
    {
        $currency = $request->input('currency', 'BTC');
        $amount = $request->input('amount', 5);

        PlisioInvoice::makeTransaction($currency, $amount);

        return response(['message' => 'OK',]);
    }
}
