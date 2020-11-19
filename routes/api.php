<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    Route::middleware('api.guard')->group(function () {
        //用户注册
        Route::post('/users', [RegisterController::class, 'store'])->name('users.store');
        //用户登录
        Route::post('/login', [LoginController::class, 'login'])->name('users.login');
        Route::middleware('token.refresh')->group(function () {
            //当前用户信息
            Route::get('/users/info', [UserController::class, 'info'])->name('users.info');
            //用户列表
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            //用户信息
            Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
            //用户退出
            Route::get('/logout', [LogoutController::class, 'logout'])->name('users.logout');
        });
    });

    Route::middleware('admin.guard')->group(function () {
        //管理员注册
        Route::post('/admins', [RegisterController::class, 'adminStore'])->name('admins.store');
        //管理员登录
        Route::post('/admins/login', [LoginController::class, 'login'])->name('admins.login');
        Route::middleware('token.refresh')->group(function () {
            //当前管理员信息
            Route::get('/admins/info', [AdminController::class, 'info'])->name('admins.info');
            //管理员列表
            Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
            //管理员退出
            Route::get('/admins/logout', [LogoutController::class, 'logout'])->name('admins.logout');
            //管理员信息
            Route::get('/admins/{user}', [AdminController::class, 'show'])->name('admins.show');
        });
    });
});


