<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Option;
use App\Models\Template;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request, int $page = 1)
    {
        $filters = session('filters', []);
        $filters['s'] = $request->query('s');

        $template = Template::inRandomOrder()->firstOrFail();
        $template->setPage($page)
            ->setFilters($filters)
            ->fillData();

        $popupAds = Ad::select('id', 'link', 'image_id')
            ->with('image')
            ->active()
            ->type('popup')
            ->limit($template->count('ad') ? 50 : 0)
            ->inRandomOrder()
            ->get();

        $settings = Option::getSettings();

        return view('pages.home', [
            'template' => $template, 
            'popupAds' => $popupAds,
            'settings' => $settings,
        ]);
    }
}
