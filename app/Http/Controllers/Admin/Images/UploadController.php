<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
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
        $uploaded = $request->file('img');
        $process = $request->input('process', true);

        $user = Auth::guard('admin')->user();

        $image = $this->imagesService->upload($user, $uploaded, $process);

        return response($image);
    }
}
