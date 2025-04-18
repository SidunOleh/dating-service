<?php

namespace App\Http\Controllers\Web\Posts;

use App\Http\Controllers\Controller;
use App\Services\Posts\PostsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyProfileLoadMoreController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(Request $request)
    {     
        $creator = Auth::guard('web')->user();

        $posts = $this->postsService->getMyPosts($creator, $request->query('page', 1));

        $html = view('templates.posts.my-posts', ['posts' => $posts])->render();

        return response(['html' => $html]);
    }
}
