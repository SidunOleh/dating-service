<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Option;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function __invoke(int $page = 1)
    {
        $template = Template::inRandomOrder()->firstOrFail();
        $template->setPage($page)
            ->setFilters(['in_favorites' => Auth::guard('web')->id(),])
            ->fillData();

        $popupAds = Ad::select('id', 'link', 'image_id')
            ->with('image')
            ->active()
            ->type('popup')
            ->limit($template->count('ad') ? 50 : 0)
            ->inRandomOrder()
            ->get();
            
        $settings = json_decode(Option::getOption('settings'), true);

        return view('pages.favorites', [
            'template' => $template, 
            'popupAds' => $popupAds,
            'settings' => $settings,
        ]);
    }
}
