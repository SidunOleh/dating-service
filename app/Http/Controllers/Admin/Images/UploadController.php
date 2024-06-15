<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
use App\Models\Image;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $image = Image::saveUploaded(
            $request->file('img'),
            $request->input('thumb', false),
            $request->input('watermark', false)
        );

        return response([
            'id' => $image->id,
            'url' => $image->url(),
        ]);
    }
}
