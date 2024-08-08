<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Option;

class FAQController extends Controller
{
    public function __invoke()
    {
        $content = Option::getContent();
        
        $faq = $content['faq'] ?? [];

        return view('pages.faq', [
            'faq' => $faq,
        ]);
    }
}
