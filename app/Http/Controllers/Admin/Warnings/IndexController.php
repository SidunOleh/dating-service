<?php

namespace App\Http\Controllers\Admin\Warnings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warning\WarningCollection;
use App\Models\Warning;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);

        $warnings = Warning::orderBy('created_at', 'DESC')
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new WarningCollection($warnings));
    }
}
