<?php

namespace App\Http\Controllers\Web\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Posts\PostsService;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(Post $post)
    {
        if (! Gate::allows('delete-post', $post)) {
            abort(403);
        }
     
        $this->postsService->delete($post);

        return response(['message' => 'OK']);
    }
}
