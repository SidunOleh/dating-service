<?php

namespace App\Http\Controllers\Web\Favorites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Favorites\AddToFavotiresRequest;
use Illuminate\Support\Facades\Auth;

class AddToFavotiresController extends Controller
{
    public function __invoke(AddToFavotiresRequest $request)
    {
        $favoriteId = $request->input('favorite_id');
        $creator = Auth::guard('web')->user();

        if (! $creator->hasInFavorites($favoriteId)) {
            $creator->favorites()->attach($favoriteId);
        }

        return response(['message' => 'OK',]);
    }
}
