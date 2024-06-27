<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' => ['required', 'captcha'],
        ]);
    }

    public function register(Request $request)
    {
        // 表单验证
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' => ['required', 'captcha'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 创建用户
        $user = User::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        // 自动登录用户
        auth()->login($user);

        // 注册成功后重定向到角色创建页面
        return redirect()->route('create_role_form');
    }

    public function showRegistrationForm()
    {
        return view('register');
    }
}
