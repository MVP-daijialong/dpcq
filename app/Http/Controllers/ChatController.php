<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $now_time = date("H:i", time());
        $user = Auth::user();
        $role = $user->role;

        // 获取最近100条聊天记录
        $chat_list = DB::table('dp_chats')->where('server_id', 1)->get()->toArray();
        $msg_arr = [];
        foreach ($chat_list as $k => $v) {
            $msg_arr[$k]['msg'] = $v->role_name . ': ' . $v->content;
        }

        $key = "history_url:{$role->role_id}";
        $history_url = Redis::get($key);

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'role' => $role,
            'msg_arr' => $msg_arr,
            'history_url' => $history_url,
        ];
        return view('chat', $data);
    }
}
