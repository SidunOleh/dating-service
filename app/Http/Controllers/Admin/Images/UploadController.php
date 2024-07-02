<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
use App\Models\Image;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $uploaded = $request->file('img');
        $process = $request->input('process', true);
        $watermark = $request->input('watermark', false);
        $quality = (int) $request->input('quality', 0);

        if ($process) {
            $manager = new ImageManager(new Driver());

            $img = $manager->read(
                $manager->read($uploaded->path())
                    ->toWebp($quality)
                    ->toFilePointer()
            );
    
            if ($watermark) {
                $watermarkImg = $manager->read(storage_path('watermark.png'));
                $watermarkImg->cover($img->width(), $img->height());
                $img->place($watermarkImg, 'center', opacity: 10);
            }
            
            $img->save($uploaded->path());
        }

        $image = Image::saveUploadedFile($uploaded);

        return response($image);
    }
}
