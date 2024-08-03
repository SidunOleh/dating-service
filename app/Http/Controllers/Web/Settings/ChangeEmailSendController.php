<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailSendRequest;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Auth;

class ChangeEmailSendController extends Controller
{
    public function __invoke(ChangeEmailSendRequest $request)
    {
        $code = Code::create('change_email', [
            'new_email' => $request->input('new_email'),
        ]);
        $code->send(Auth::guard('web')->user()->email);

        return response(['message' => 'OK',]);
    }
}
