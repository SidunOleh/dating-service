<?php

namespace App\Http\Controllers\Admin\Transfers;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');

        $creators = Creator::select(['id', 'email', 'balance', 'balance_2', 'balance_earn',])
            ->where('balance_earn', '>', 0)
            ->orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return response($creators);
    }
}
