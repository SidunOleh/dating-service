<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        Option::updateOrCreate(
            ['name' => 'content',], 
            ['value' => json_encode($request->all()),]
        );

        return response(['message' => 'OK',]);
    }
}
