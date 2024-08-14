<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
use App\Jobs\ProcessImage;
use App\Models\Image;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $uploaded = $request->file('img');
        $process = $request->input('process', false);
        $watermark = $request->input('watermark', false);
        $quality = (int) $request->input('quality', 0);

        $image = Image::saveUploadedFile($uploaded);

        if ($process) {
            ProcessImage::dispatch($image, $quality, $watermark)->delay(now()->addMinutes(1));
        }

        return response($image);
    }
}
