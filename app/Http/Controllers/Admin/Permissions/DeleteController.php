<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class DeleteController extends Controller
{
    public function __invoke(Permission $permission)
    {
        if ($permission->roles()->count() > 0) {
            return response(['message' => 'Can not delete permission with roles.',], 400);
        }

        $permission->delete();

        return response(['messsage' => 'OK',]);
    }
}
