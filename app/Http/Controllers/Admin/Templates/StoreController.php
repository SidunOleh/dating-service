<?php

namespace App\Http\Controllers\Admin\Templates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Templates\StoreRequest;
use App\Models\Template;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $template = Template::create($request->validated());

        return response(['id' => $template->id,]);
    }
}
