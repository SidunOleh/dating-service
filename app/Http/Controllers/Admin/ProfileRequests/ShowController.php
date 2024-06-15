<?php

namespace App\Http\Controllers\Admin\ProfileRequests;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileRequest\ProfileRequestResource;
use App\Models\ProfileRequest;

class ShowController extends Controller
{
    public function __invoke(ProfileRequest $profileRequest)
    {    
        return response(new ProfileRequestResource($profileRequest));
    }
}
