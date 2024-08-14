<?php

namespace App\Http\Controllers\Web\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Images\UploadRequest;
use App\Jobs\ProcessImage;
use App\Models\Image;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->canUpload()) {
            abort(429, 'Too many uploads(' . Upload::MAX . ' per day)');
        }

        Upload::create(['creator_id' => $creator->id,]);

        $image = Image::saveUploadedFile($request->file('img'));

        ProcessImage::dispatch($image, 10, $request->input('watermark', false));

        return response($image);
    }
}