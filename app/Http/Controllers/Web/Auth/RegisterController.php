<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\RegisterRequest;
use App\Models\Creator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $creator = Creator::create($request->validated());

        Auth::login($creator);

        return response(['message' => 'OK',]);
    }
}
