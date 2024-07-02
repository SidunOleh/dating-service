<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Models\Image;

class DeleteController extends Controller
{
    public function __invoke(Image $image)
    {
        $image->delete();

        return response(['message' => 'OK',]);
    }
}
