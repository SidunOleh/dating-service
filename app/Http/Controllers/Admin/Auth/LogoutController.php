<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function __invoke()
    {
        Auth::guard('admin')->logout();
 
        Session::invalidate();
        Session::regenerateToken();

        return response(['messsage' => 'OK',]);
    }
}
