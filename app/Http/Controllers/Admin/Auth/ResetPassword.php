<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ResetPasswordReqest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPassword extends Controller
{
    public function __invoke(ResetPasswordReqest $request)
    {
        $credentials = $request->validated();

        $status = Password::reset($credentials, function (User $user, string $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return response(['message' => __($status),], $status == Password::PASSWORD_RESET ? 200 : 400);
    }
}
