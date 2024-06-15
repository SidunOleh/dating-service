<?php

namespace App\Http\Controllers\Admin\Templates;

use App\Http\Controllers\Controller;
use App\Models\Template;

class DeleteController extends Controller
{
    public function __invoke(Template $template)
    {
        $template->delete();
     
        return response(['message' => 'OK',]);
    }
}
