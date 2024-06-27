<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function roleState(Request $request)
    {
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $now_time = date("H:i", time());

        // 查角色
        $roles_info = DB::table('dp_roles')
            ->select('dp_roles.role_id', 'dp_roles.role_name', 'dp_roles_attribute.*')
            ->leftJoin('dp_roles_attribute', 'dp_roles.role_id', '=', 'dp_roles_attribute.r_id')
            ->where('role_id', $role_id)
            ->first();

        // 获取下一等级需要经验
        $level_info = DB::table('dp_levels')->where('level', $roles_info->r_level + 1)->first();
        $roles_info->next_level_exp = $level_info->exp;

        // 查境界
        $level_info = DB::table('dp_levels')->where('level', $roles_info->r_level)->first();
        $plevel_info = DB::table('dp_plevels')->where('level_id', $level_info->pid)->first();

        $roles_info->realm_name = '☆' . $plevel_info->level_name . $level_info->level_name;
        $roles_info->realm_desc = $plevel_info->desc;

        // 查6个装备位置信息
        $equip_list = DB::table('dp_roles_equip')
            ->select(
                'dp_roles_equip.*', 'dp_items.item_name', 'dp_items.color',
                'dp_equip_attribute.e_quality', 'dp_equip_attribute.e_level',
                'dp_equip_attribute.suit_id'
            )
            ->leftJoin('dp_items', 'dp_roles_equip.item_id', '=', 'dp_items.item_id')
            ->leftJoin('dp_equip_attribute', 'dp_roles_equip.item_id', '=', 'dp_equip_attribute.item_id')
            ->where('role_id', $role_id)
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();

        // 1白 2赤 3橙 4黄 5绿 6青 7蓝 8紫
        $color_dist = [
            1 => '白',
            2 => '赤',
            3 => '橙',
            4 => '黄',
            5 => '绿',
            6 => '青',
            7 => '蓝',
            8 => '紫',
        ];
        $equip_arr = [];
        $suit_id = 0;
        $suit_info = [];
        foreach ($equip_list as $v) {
            $equip_arr[$v['e_position']]['id'] = $v['id'];
            $equip_arr[$v['e_position']]['item_id'] = $v['item_id'];
            $equip_arr[$v['e_position']]['item_name'] = $v['item_name'];
            $equip_arr[$v['e_position']]['color'] = $v['color'];
            $equip_arr[$v['e_position']]['e_quality'] = $color_dist[$v['e_quality']] ?? $v['e_quality'];
            $equip_arr[$v['e_position']]['e_level'] = $v['e_level'];
            $equip_arr[$v['e_position']]['suit_id'] = $v['suit_id'];
        }

        // 判断是否是套装
        if (isset($equip_arr[1]['suit_id']) && isset($equip_arr[2]['suit_id']) && isset($equip_arr[4]['suit_id']) && isset($equip_arr[5]['suit_id'])) {
            if (
                $equip_arr[1]['suit_id'] == $equip_arr[2]['suit_id'] &&
                $equip_arr[2]['suit_id'] == $equip_arr[4]['suit_id'] &&
                $equip_arr[4]['suit_id'] == $equip_arr[5]['suit_id']
            ) {
                $suit_id = $equip_arr[1]['suit_id'];
            }

        }

        if ($suit_id) {
            $suit_info = DB::table('dp_equip_suit')->where('suit_id', $suit_id)->first();
        }

        // 查询是否配置了药品
        $tlb_info = DB::table('dp_tlb')
            ->select('dp_tlb.*', 'dp_items.item_name', 'dp_items.color')
            ->leftJoin('dp_items', 'dp_tlb.item_id', '=', 'dp_items.item_id')
            ->where('role_id', $role_id)
            ->first();

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'roles_info' => $roles_info,
            'equip_arr' => $equip_arr,
            'suit_info' => $suit_info,
            'tlb_info' => $tlb_info
        ];
        return view('role_state', $data);
    }

    public function targetState(Request $request)
    {
        $id = $request->input('id');
        $now_time = date("H:i", time());

        // 查怪物
        $target_info = DB::table('dp_attack_target')
            ->select('dp_attack_target.id', 'dp_attack_target.target_name', 'dp_attack_target.target_des', 'dp_attack_target.target_pic', 'dp_attribute.*')
            ->leftJoin('dp_attribute', 'dp_attack_target.id', '=', 'dp_attribute.t_id')
            ->where('dp_attack_target.id', $id)
            ->first();

        // 查境界
        $level_info = DB::table('dp_levels')->where('level', $target_info->t_level)->first();
        $plevel_info = DB::table('dp_plevels')->where('level_id', $level_info->pid)->first();

        $target_info->realm_name = '☆' . $plevel_info->level_name . $level_info->level_name;
        $target_info->realm_desc = $plevel_info->desc;

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'target_info' => $target_info,
        ];
        return view('target_state', $data);
    }

    public function itemInfo(Request $request)
    {
        $item_id = $request->input('item_id');
        $type = $request->input('type'); // 1 装备 2 道具
        $now_time = date("H:i", time());

        $equip_info = [];
        $item_info = [];
        switch ($type) {
            case 1:
                $equip_info = DB::table('dp_items')
                    ->select('dp_items.item_name', 'dp_items.color', 'dp_items.pic', 'dp_items.desc', 'dp_equip_attribute.*')
                    ->leftJoin('dp_equip_attribute', 'dp_items.item_id', '=', 'dp_equip_attribute.item_id')
                    ->where('dp_items.item_id', $item_id)
                    ->first();
                break;
            case 2:
                $item_info = DB::table('dp_items')
                    ->select('dp_items.item_name', 'dp_items.color', 'dp_items.pic', 'dp_items.desc', 'dp_recover_items.*')
                    ->leftJoin('dp_recover_items', 'dp_items.item_id', '=', 'dp_recover_items.item_id')
                    ->where('dp_items.item_id', $item_id)
                    ->first();
                break;
        }

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'equip_info' => $equip_info,
            'item_info' => $item_info,
            'type' => $type
        ];
        return view('item_info', $data);
    }

    public function takeOffTlb(Request $request)
    {
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $status = $request->input('status');

        $res = DB::table('dp_tlb')->where('role_id', $role_id)->update(['status' => $status]);
        if ($res) {
            $msg = $status == 0 ? '已解除' : '已穿戴';
            return response()->json(['success' => true, 'msg' => $msg]);
        } else {
            return response()->json(['success' => false, 'msg' => '解除失败']);
        }
    }
}
