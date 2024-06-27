<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        // 使用中间件检查用户是否登录
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return redirect()->route('login'); // 重定向到登录页面
            }
            return $next($request);
        });
    }
}
