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

        $key = "history_url:{$role->role_id}";
        $history_url = Redis::get($key);

        // 解析URL中的查询部分
        $parsed_url = parse_url($history_url, PHP_URL_QUERY);

        // 将查询参数解析为数组
        parse_str($parsed_url, $query_params);

        // 提取map_id的值
        $map_id = $query_params['map_id'] ?? 0;

        // 获取世界频道最近100条聊天记录
        $chat_list = DB::table('dp_chats')->where('server_id', 1)->where('map_id', 0)->limit(100)->get()->toArray();
        $world_msg_arr = [];
        foreach ($chat_list as $k => $v) {
            $world_msg_arr[$k]['msg'] = "[" . $v->created_at . "] " . $v->role_name . ': ' . $v->content;
        }

        // 获取当前频道最近100条聊天记录
        $chat_list = DB::table('dp_chats')->where('server_id', 1)->where('map_id', $map_id)->limit(100)->get()->toArray();
        $current_msg_arr = [];
        foreach ($chat_list as $k => $v) {
            $current_msg_arr[$k]['msg'] = "[" . $v->created_at . "] " . $v->role_name . ': ' . $v->content;
        }

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'role' => $role,
            'world_msg_arr' => $world_msg_arr,
            'current_msg_arr' => $current_msg_arr,
            'history_url' => $history_url,
            'map_id' => $map_id,
        ];
        return view('chat', $data);
    }
}
