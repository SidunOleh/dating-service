<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $uploaded = $request->file('img');
        $process = $request->input('process', false);
        $watermark = $request->input('watermark', false);
        $quality = (int) $request->input('quality', 0);

        if ($process) {
            Image::processUploadedFile($uploaded, $watermark, $quality);
        }

        $image = Image::saveUploadedFile($uploaded, Auth::guard('admin')->user());

        return response($image);
    }
}
