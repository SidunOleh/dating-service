<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class DeleteController extends Controller
{
    public function __invoke(Role $role)
    {
        if ($role->users()->count() > 0) {
            return response(['message' => 'Can not delete role with users.',], 400);
        }

        $role->delete();

        return response(['message' => 'OK',]);
    }
}
