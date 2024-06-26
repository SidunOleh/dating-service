<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
use App\Models\Image;
use Exception;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $uploaded = $request->file('img');
        $process = $request->input('process', true);
        $watermark = $request->input('watermark', false);
        $quality = $request->input('quality', 0);
        
        try {
            if ($process) {
                Image::processUploaded($uploaded, $watermark, $quality);
            }
    
            $image = Image::saveUploaded($uploaded);
    
            return response($image);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(),], 400);
        }
    }
}
