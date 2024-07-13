<?php

namespace App\Http\Controllers\Web\Images;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function __invoke(Image $image)
    {
        $creator = Auth::guard('web')->user();

        if ($creator->isNot($image->user)) {
            return abort(403);
        }

        $image->delete();

        return response(['message' => 'OK',]);
    }
}
