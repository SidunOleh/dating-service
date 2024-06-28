<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Image $image)
    {
        $image->delete();
        $image->deleteFile();

        return response(['message' => 'OK',]);
    }
}
