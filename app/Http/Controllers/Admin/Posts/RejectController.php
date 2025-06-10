<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\RejectRequest;
use App\Models\Post;
use App\Services\Posts\PostsService;

class RejectController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(Post $post, RejectRequest $request)
    {
        $this->postsService->reject($post, $request->comment);

        $next = $this->postsService->getPostInPending();

        return response(['next' => $next?->id,]);
    }
}
