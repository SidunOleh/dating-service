<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);

        $users = User::orderBy('created_at', 'DESC')
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new UserCollection($users));
    }
}
