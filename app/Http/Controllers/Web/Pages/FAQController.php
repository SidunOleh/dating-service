<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    public function __invoke()
    {
        return view('pages.faq');
    }
}
