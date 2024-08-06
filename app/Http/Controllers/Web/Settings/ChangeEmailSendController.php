<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailSendRequest;
use App\Services\Verification\Code;

class ChangeEmailSendController extends Controller
{
    public function __invoke(ChangeEmailSendRequest $request)
    {
        $code = Code::create('change_email', [
            'new_email' => $request->input('new_email'),
        ]);
        $code->send($request->input('new_email'));

        return response(['message' => 'OK',]);
    }
}
