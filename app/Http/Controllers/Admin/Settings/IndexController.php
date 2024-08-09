<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Settings\SettingsCollection;
use App\Models\Option;

class IndexController extends Controller
{
    public function __invoke()
    {
        $settings = Option::getSettings();
        
        return response($settings);
    }
}
