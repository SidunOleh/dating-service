<?php

namespace App\Http\Controllers\Admin\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DeleteController extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        $transaction->details->delete();
        $transaction->delete();

        return response(['message' => 'OK',]);
    }
}
