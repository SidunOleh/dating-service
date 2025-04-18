<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $status = $request->query('status', []);
 
        $posts = Post::orderBy($orderby, $order)
            ->with('creator')
            ->status($status)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new PostCollection($posts));
    }
}
