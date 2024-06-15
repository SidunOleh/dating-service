<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Http\Controllers\Controller;
use App\Http\Resources\Creator\CreatorResource;
use App\Models\Creator;

class ShowController extends Controller
{
    public function __invoke(Creator $creator)
    {
        return response(new CreatorResource($creator));
    }
}
