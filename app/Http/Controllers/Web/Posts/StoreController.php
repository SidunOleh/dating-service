<?php

namespace App\Http\Controllers\Web\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Posts\StoreRequest;
use App\Services\Posts\PostsService;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __construct(
        public PostsService $postsService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $creator = Auth::guard('web')->user();
     
        if ($creator->postInPending) {
            return response(['message' => 'Ooops'], 400);
        }

        $this->postsService->create($creator, $request->validated());

        return response(['message' => 'OK']);
    }
}
