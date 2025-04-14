<?php

namespace App\Http\Controllers\Web\Settings;

use App\Exceptions\TooFastException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailResendRequest;
use App\Services\Verification\Code;

class ChangeEmailResendController extends Controller
{
    public function __invoke(ChangeEmailResendRequest $request)
    {
        try {
            $code = new Code('change_email');
            
            $data = $code->data();

            $code->resend($data['new_email']);

            return response(['message' => 'OK',]);
        } catch (TooFastException $e) {
            return response(['message' => 'Too fast.',], 400);
        }
    }
}
