<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Controller;
use App\Http\Resources\Ad\AdCollection;
use App\Models\Ad;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);
        $type = $request->query('type');

        $ads = Ad::orderBy('created_at', 'DESC')
            ->type($type)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new AdCollection($ads));
    }
}
