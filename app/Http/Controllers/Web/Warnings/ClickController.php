<?php

namespace App\Http\Controllers\Web\Warnings;

use App\Http\Controllers\Controller;
use App\Models\Warning;

class ClickController extends Controller
{
    public function __invoke(Warning $warning)
    {
        $warning->clicks_count += 1;
        $warning->save();

        return response(['message' => 'OK',]);
    }
}
