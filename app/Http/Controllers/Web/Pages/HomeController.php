<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $template = Template::inRandomOrder()->firstOrFail();
        $template->fillData(1);

        dd($template->total(), ...$template->blocks);
    }
}
