<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogOutController extends Controller
{
    public function __invoke()
    {
        Auth::guard('web')->logout();
 
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('home.index');
    }
}
