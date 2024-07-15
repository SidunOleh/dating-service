<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __invoke(Creator $creator)
    {
        if (
            ! $creator->is_approved or 
            ! $creator->show_on_site or
            $creator->is_banned
        ) {
            return redirect()->route('home');
        }

        if (
            Auth::guard('web')->check() and 
            Auth::guard('web')->user()->subscription
        ) {
            $recommendCount = count($creator->photos) * 3;
        } else {
            $recommendCount = count($creator->photos) > 3 ? 3 : count($creator->photos);
            $recommendCount = $recommendCount * 3 + 3;
        }

        $recommendations = Creator::recommendations($recommendCount, [$creator->id,], session('filters', []));

        if ($recommendations->count() < $recommendCount) {
            $count = $recommendCount - $recommendations->count();
            $exlude = [$creator->id, ...$recommendations->pluck('id')->all(),];

            $recommendations = $recommendations->merge(Creator::recommendations($count, $exlude));
        }

        $favorites = Auth::guard('web')->check() ? 
            Auth::guard('web')->user()->favorites : 
            new Collection();

        $creator->loadCount('inFavorites');

        return view('pages.profile', [
            'creator' => $creator,
            'recommendations' => $recommendations,
            'favorites' => $favorites,
        ]);
    }
}
