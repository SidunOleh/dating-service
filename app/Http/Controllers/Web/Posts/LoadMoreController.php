<?php

namespace App\Http\Controllers\Web\Posts;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Services\Posts\PostsService;
use Illuminate\Http\Request;

class LoadMoreController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(Creator $creator, Request $request)
    {     
        $posts = $this->postsService->getPosts($creator, $request->query('page', 1));

        $html = view('templates.posts.posts', ['posts' => $posts])->render();

        return response(['html' => $html]);
    }
}
