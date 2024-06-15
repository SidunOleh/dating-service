<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::guard('admin')->attempt($credentials)) {
            return response(['message' => 'Wrong credentials.',], 401);
        }

        return response(['user' => new UserResource(Auth::guard('admin')->user()),]);
    }
}
