<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Option;
use App\Models\Template;
use App\Models\ZipCode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke(Request $request, int $page = 1)
    {
        $filters = [];
        $filters['s'] = $request->query('s');
        $filters['gender'] = $request->query('gender');

        if (
            $zip = $request->query('zip') and
            $zipCode = ZipCode::where('zip', $zip)->first() and
            $miles = $request->query('miles')
        ) {
            $filters['center']['lat'] = $zipCode->latitude;
            $filters['center']['lng'] = $zipCode->longitude;
            $filters['radius'] = $miles * 1609;
        }

        session(['filters' => $filters,]);

        $template = Template::inRandomOrder()->firstOrFail();
        $template->setPage($page)
            ->setFilters($filters)
            ->fillData();

        $favorites =  Auth::guard('web')->check() ? 
            Auth::guard('web')->user()->favorites : 
            new Collection();

        $popupAds = $template->count('ad') ? Ad::select('id', 'link', 'image_id')
            ->with('image')
            ->active()
            ->type('popup')
            ->limit(50)
            ->inRandomOrder()
            ->get() : new Collection();
        $adsSettings = Option::getOptions([
            'clicks_between_popups', 
            'seconds_between_popups', 
            'close_popup_seconds',
        ]);

        return view('pages.home', [
            'template' => $template, 
            'favorites' => $favorites,
            'popupAds' => $popupAds,
            'adsSettings' => $adsSettings,
        ]);
    }
}
