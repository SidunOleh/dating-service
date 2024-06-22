<?php

namespace App\Http\Controllers\Web\Password;

use App\Http\Controllers\Controller;

class ResetPageController extends Controller
{
    public function __invoke()
    {
        return view('pages.reset');
    }
}
