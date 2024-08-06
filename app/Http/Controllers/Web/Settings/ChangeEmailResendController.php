<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\ChangeEmailResendRequest;
use App\Services\Verification\Code;
use Exception;

class ChangeEmailResendController extends Controller
{
    public function __invoke(ChangeEmailResendRequest $request)
    {
        try {
            $code = new Code('change_email');
            
            $data = $code->data();

            $code->resend($data['new_email']);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
