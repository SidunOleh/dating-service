<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;

class ProfileController extends Controller
{
    public function __invoke(Creator $creator)
    {
        if (
            ! $creator->is_approved or 
            ! $creator->show_on_site or
            $creator->is_banned
        ) {
            return abort(404);
        }

        $count = count($creator->photos) * 3;
        $exclude = [$creator->id,];

        $recommends = Creator::recommends(
            $count, 
            $exclude, 
            session('filters', [])
        );

        if ($recommends->count() < $count) {
            $count = $count - $recommends->count();
            $exclude = [...$exclude, ...$recommends->pluck('id')];

            $recommends = $recommends->merge(Creator::recommends(
                $count,  
                $exclude
            ));
        }

        return view('pages.profile', [
            'creator' => $creator,
            'recommends' => $recommends,
        ]);
    }
}
