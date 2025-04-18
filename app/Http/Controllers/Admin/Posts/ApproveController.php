<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Posts\PostsService;

class ApproveController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(Post $post)
    {
        $this->postsService->approve($post);

        return response(['message' => 'OK']);
    }
}
