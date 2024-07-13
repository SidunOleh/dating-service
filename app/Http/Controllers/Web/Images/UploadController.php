<?php

namespace App\Http\Controllers\Web\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Images\UploadRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $uploaded = $request->file('img');
        $watermark = $request->input('watermark', false);

        Image::processUploadedFile($uploaded, $watermark, 20);

        $image = Image::saveUploadedFile($uploaded, Auth::guard('web')->user());

        return response($image);
    }
}
