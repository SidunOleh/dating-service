<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Http\Controllers\Controller;
use App\Http\Resources\Creator\CreatorCollection;
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
        $q = $request->query('q', '');

        $creators = Creator::adminSearch($q)
            ->orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new CreatorCollection($creators));
    }
}
