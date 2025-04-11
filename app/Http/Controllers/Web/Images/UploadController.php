<?php

namespace App\Http\Controllers\Web\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Images\UploadRequest;
use App\Models\Upload;
use App\Services\Images\ImagesService;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function __construct(
        public ImagesService $imagesService
    )
    {
        
    }

    public function __invoke(UploadRequest $request)
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->canUpload()) {
            return response(['message' => 'Too many uploads(' . Upload::MAX . ' per day)'], 429);
        }

        $image = $this->imagesService->upload($creator, $request->file('img'), true);

        return response($image);
    }
}