<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleCollection;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);

        $roles = Role::where('guard_name', 'admin')
            ->orderBy('created_at', 'DESC')
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new RoleCollection($roles));
    }
}
