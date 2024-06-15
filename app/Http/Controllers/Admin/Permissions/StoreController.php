<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\StoreRequest;
use Spatie\Permission\Models\Permission;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['guard_name'] = 'admin';

        Permission::create($data);
        
        return response(['message' => 'OK',]);
    }
}
