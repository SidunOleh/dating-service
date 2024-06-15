<?php

namespace App\Http\Controllers\Admin\Templates;

use App\Http\Controllers\Controller;
use App\Http\Resources\Template\TemplateCollection;
use App\Models\Template;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);

        $templates = Template::orderBy('created_at', 'DESC')
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new TemplateCollection($templates));
    }
}
