<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Models\Option;
use App\Services\Creators\CreatorsService;
use App\Services\Posts\PostsService;

class ProfileController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService,
        public PostsService $postsService
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
        
        $recommcendsCount = count($creator->photos) * 3;
        $recommcendsCount = $recommcendsCount < 4 ? 4 : $recommcendsCount;
        $recommends = $this->creatorsService->recommends(
            $recommcendsCount,
            [$creator->id,], 
            session('filters', [])
        );

        $settings = Option::getSettings();

        $posts = $this->postsService->getPosts($creator, 1);

        return view('pages.profile', [
            'creator' => $creator,
            'recommends' => $recommends,
            'show_contacts' => $settings['show_contacts'],
            'posts' => $posts,
        ]);
    }
}
