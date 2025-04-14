<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Models\Option;
use App\Services\Creators\CreatorsService;

class ProfileController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService
    )
    {
        
    }

    public function __invoke(Creator $creator)
    {
        if (
            ! $creator->is_approved or 
            ! $creator->show_on_site or
            $creator->is_banned
        ) {
            return abort(404);
        }
        
        $recommends = $this->creatorsService->recommends(
            count($creator->photos) * 3,
            [$creator->id,], 
            session('filters', [])
        );

        $settings = Option::getSettings();

        return view('pages.profile', [
            'creator' => $creator,
            'recommends' => $recommends,
            'show_contacts' => $settings['show_contacts'],
        ]);
    }
}
