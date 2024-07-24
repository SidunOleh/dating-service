<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;
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
            return abort(404);
        }

        $recommendations = Creator::recommendations(
            count($creator->photos) * 3, 
            [$creator->id,], 
            session('filters', [])
        );

        return view('pages.profile', [
            'creator' => $creator,
            'recommendations' => $recommendations,
        ]);
    }
}
