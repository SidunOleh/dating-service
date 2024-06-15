<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);

        $permissions = Permission::where('guard_name', 'admin')
            ->orderBy('created_at', 'DESC')
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new PermissionCollection($permissions));
    }
}
