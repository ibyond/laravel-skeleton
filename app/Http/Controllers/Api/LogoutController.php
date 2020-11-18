<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }

    public function adminLogout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }
}
