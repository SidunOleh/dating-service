<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        return view('pages.settings', [
            'creator' => $creator,
        ]);
    }
}
