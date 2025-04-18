<?php

namespace App\Http\Controllers\Web\Posts;

use App\Exceptions\NotEnoughMoneyException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Posts\OpenRequest;
use App\Models\Post;
use App\Services\Posts\PostsService;
use Illuminate\Support\Facades\Auth;

class OpenController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(Post $post, OpenRequest $request)
    {
        try {
            $creator = Auth::guard('web')->user();

            $open = $this->postsService->open($post, $creator, $request->button_number);

            $html = '';
            if ($open) {
                $html = view('templates.posts.posts', ['posts' => [$post]])->render();
            }
    
            return response([
                'open' => $open,
                'balance' => $creator->balance,
                'balance_2' => $creator->balance_2_total,
                'html' => $html,
            ]);
        } catch (NotEnoughMoneyException $e) {
            return response(['message' => 'Balance is too low!'], 400);
        }
    }
}
