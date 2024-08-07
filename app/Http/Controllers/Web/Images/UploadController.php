<?php

namespace App\Http\Controllers\Web\Images;

use App\Events\ImageUploaded;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Images\UploadRequest;
use App\Models\Image;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function __invoke(UploadRequest $request)
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->canUpload()) {
            abort(429, 'Too many uploads');
        }

        Upload::create(['creator_id' => $creator->id,]);

        $uploaded = $request->file('img');
        $watermark = $request->input('watermark', false);

        $image = Image::saveUploadedFile($uploaded);

        ImageUploaded::dispatch($image, true, 10, $watermark);

        return response($image);
    }
}
