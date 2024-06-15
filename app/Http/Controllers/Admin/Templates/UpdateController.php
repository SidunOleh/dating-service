<?php

namespace App\Http\Controllers\Admin\Templates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Templates\UpdateRequest;
use App\Models\Template;

class UpdateController extends Controller
{
    public function __invoke(
        Template $template, 
        UpdateRequest $request
    )
    {
        $template->update($request->validated());
     
        return response(['message' => 'OK',]);
    }
}
