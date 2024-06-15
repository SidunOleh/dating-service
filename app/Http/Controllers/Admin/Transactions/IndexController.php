<?php

namespace App\Http\Controllers\Admin\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');

        $transactions = Transaction::orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new TransactionCollection($transactions));
    }
}
