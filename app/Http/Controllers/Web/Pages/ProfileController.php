<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Creator;
use App\Models\Option;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __invoke(Creator $creator)
    {
        if (
            ! $creator->is_approved or 
            ! $creator->show_on_site
        ) {
            return redirect()->route('home');
        }

        if (
            Auth::guard('web')->check() and 
            Auth::guard('web')->user()->subscription
        ) {
            $recommendationsCount = count($creator->photos) * 3;
        } else {
            $recommendationsCount = count($creator->photos) > 3 ? 3 : count($creator->photos);
            $recommendationsCount = $recommendationsCount * 3 + 3;
        }

        $recommendations = 
            Creator::recommendations($recommendationsCount, [$creator->id,], session('filters', []));
        if (! $recommendations->count()) {
            $recommendations = 
                Creator::recommendations($recommendationsCount, [$creator->id,]);
        }

        $favorites = Auth::guard('web')->check() ? 
            Auth::guard('web')->user()->favorites : 
            new Collection();

        $creator->loadCount('inFavorites');

        $topAd = Ad::type('top')
            ->inRandomOrder()
            ->first();
        $adsSettings = Option::getOptions([
            'show_top_ad',
        ]);

        return view('pages.profile', [
            'creator' => $creator,
            'recommendations' => $recommendations,
            'favorites' => $favorites,
            'topAd' => $topAd,
            'adsSettings' => $adsSettings,
        ]);
    }
}
