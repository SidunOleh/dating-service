<?php

namespace App\Http\Controllers\Admin\ZipCodes;

use App\Http\Controllers\Controller;
use App\Models\ZipCode;

class ShowController extends Controller
{
    public function __invoke(ZipCode $zipCode)
    {
        return $zipCode;
    }
}
