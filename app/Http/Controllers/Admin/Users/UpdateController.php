<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;

class UpdateController extends Controller
{
    public function __invoke(User $user, UpdateRequest $request)
    {
        $user->update($request->validated());
        $user->syncRoles($request->only(['role']));
        
        return response(['message' => 'OK',]);
    }
}
