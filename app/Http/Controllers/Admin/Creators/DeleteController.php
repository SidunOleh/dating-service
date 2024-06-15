<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Http\Controllers\Controller;
use App\Models\Creator;

class DeleteController extends Controller
{
    public function __invoke(Creator $creator)
    {
        $creator->delete();

        return response(['message' => 'OK',]);
    }
}
