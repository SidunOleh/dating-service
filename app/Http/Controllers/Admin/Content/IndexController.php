<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Option;

class IndexController extends Controller
{
    public function __invoke()
    {
        $content = Option::getContent();

        return response($content);
    }
}
