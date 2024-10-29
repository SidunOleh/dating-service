<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\SignUpSendCodeRequest;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Cookie;

class SignUpSendCodeController extends Controller
{
    public function __invoke(SignUpSendCodeRequest $request)
    {
        $credentials = $request->only(['email', 'password',]);

        $credentials['show_on_site'] = true;
        $credentials['play_roulette'] = true;

        $code = Code::create('signup', $credentials);
        $code->send($credentials['email']);

        if ($from = $request->input('from')) {
            Cookie::queue('from', $from);
        }

        return response(['message' => 'OK',]);
    }
}
