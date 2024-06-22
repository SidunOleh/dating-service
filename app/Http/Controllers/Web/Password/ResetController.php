<?php

namespace App\Http\Controllers\Web\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Password\ResetRequest;
use App\Models\Creator;
use Illuminate\Support\Facades\Password;

class ResetController extends Controller
{
    public function __invoke(ResetRequest $request)
    {
        $credentials = $request->validated();

        $status = Password::broker('creators')->reset($credentials, function (Creator $creator, string $password) {
            $creator->password = $password;
            $creator->save();
        });

        return response(['message' => __($status),], $status == Password::PASSWORD_RESET ? 200 : 400);
    }
}
