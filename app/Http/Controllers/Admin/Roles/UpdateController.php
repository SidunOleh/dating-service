<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\UpdateRequest;
use Spatie\Permission\Models\Role;

class UpdateController extends Controller
{
    public function __invoke(Role $role, UpdateRequest $request)
    {
        $data = $request->validated();

        $role->update($data);
        $role->syncPermissions($data['permissions']);

        return response(['message' => 'OK',]);
    }
}
