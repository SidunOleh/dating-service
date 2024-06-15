<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\StoreRequest;
use Spatie\Permission\Models\Role;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['guard_name'] = 'admin';

        $role = Role::create($data);
        $role->syncPermissions($data['permissions']);
        
        return response(['message' => 'OK',]);
    }
}
