<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // 重定向路径
    protected $redirectTo = '/index';

    // 构造函数
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 重写 login 方法，添加验证码验证
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

        if (Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password')])) {
            // 认证成功的逻辑
            return redirect()->intended($this->redirectTo);
        } else {
            // 认证失败的逻辑，例如返回错误信息
            return redirect()->back()->withInput()->withErrors(['name' => __('auth.failed')]);
        }
    }


    public function showLoginForm()
    {
        return view('login');
    }
}
