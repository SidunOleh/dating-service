<?php

namespace App\Http\Controllers\Admin\Warnings;

use App\Http\Controllers\Controller;
use App\Models\Warning;

class DeleteController extends Controller
{
    public function __invoke(Warning $warning)
    {
        $warning->delete();

        return response(['message' => 'OK',]);
    }
}
