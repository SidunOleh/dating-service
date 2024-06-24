<?php

namespace App\Http\Controllers\Web\Favorites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Favorites\RemoveFromFavotiresRequest;
use Illuminate\Support\Facades\Auth;

class RemoveFromFavotiresController extends Controller
{
    public function __invoke(RemoveFromFavotiresRequest $request)
    {
        $creator = Auth::guard('web')->user();

        $creator->favorites()->detach($request->input('favorite_id'));

        return response(['message' => 'OK',]);
    }
}
