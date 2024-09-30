<?php

namespace App\Http\Controllers\Admin\Warnings;

use App\Http\Controllers\Controller;
use App\Models\Option;

class ShowSettingsController extends Controller
{
    public function __invoke()
    {
        $settings = Option::getSettings();

        return response([
            'show_top_warning' => $settings['show_top_warning'],
        ]);
    }
}
