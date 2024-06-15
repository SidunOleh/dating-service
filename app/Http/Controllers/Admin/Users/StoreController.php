<?php

namespace App\Http\Controllers\Admin\Users;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Models\User;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
        $user->assignRole($data['role']);

        UserCreated::dispatch($user, $data['password']);

        return response(['messsage' => 'OK',]);
    }
}
