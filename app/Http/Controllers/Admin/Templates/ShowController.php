<?php

namespace App\Http\Controllers\Admin\Templates;

use App\Http\Controllers\Controller;
use App\Http\Resources\Template\TemplateResource;
use App\Models\Template;

class ShowController extends Controller
{
    public function __invoke(Template $template)
    {     
        return response(new TemplateResource($template));
    }
}
