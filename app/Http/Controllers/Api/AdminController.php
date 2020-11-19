<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use App\Http\Resources\Admin as AdminResource;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //返回用户列表
    public function index()
    {
        //3个用户为一页
        $admins = Admin::paginate(3);
        return AdminResource::collection($admins);
    }

    //返回单一用户信息
    public function show(Admin $admin)
    {
        return $this->success(new AdminResource($admin));
    }

    //返回当前登录用户信息
    public function info()
    {
        $admins = Auth::user();
        return $this->success(new AdminResource($admins));
    }

}
