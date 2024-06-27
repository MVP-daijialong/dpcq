<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function equipBag(Request $request)
    {
        $now_time = date("H:i", time());
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $query = DB::table('dp_roles_equip_bag');

        // 处理搜索关键字
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('item_name', 'like', '%' . $search . '%');
        } else {
            $search = '';
        }

        $bag_list = $query->select('dp_roles_equip_bag.id', 'dp_roles_equip_bag.item_id', 'dp_items.item_name', 'dp_items.color', 'dp_equip_attribute.e_position')
            ->leftJoin('dp_items', 'dp_roles_equip_bag.item_id', '=', 'dp_items.item_id')
            ->leftJoin('dp_equip_attribute', 'dp_roles_equip_bag.item_id', '=', 'dp_equip_attribute.item_id')
            ->where('role_id', $role_id)
            ->where('status', 1)
            ->orderBy('dp_roles_equip_bag.id', 'desc')
            ->paginate(10);

        $key = "history_url:{$role_id}";
        $history_url = Redis::get($key);

        $dist = [
            1 => '头', 2 => '身', 3 => '手', 4 => '腰', 5 => '脚', 6 => '饰',
        ];
        foreach ($bag_list as $v) {
            $v->e_position_name = $dist[$v->e_position] ?? $v->e_position;
        }

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'bag_list' => $bag_list,
            'search' => $search,
            'history_url' => $history_url,
        ];
        return view('equip_bag', $data);
    }

    public function itemBag(Request $request)
    {
        $now_time = date("H:i", time());
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $query = DB::table('dp_roles_item_bag');

        // 处理搜索关键字
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('item_name', 'like', '%' . $search . '%');
        } else {
            $search = '';
        }

        $bag_list = $query->select('dp_roles_item_bag.id', 'dp_roles_item_bag.num', 'dp_roles_item_bag.item_id', 'dp_items.item_name', 'dp_items.color')
            ->leftJoin('dp_items', 'dp_roles_item_bag.item_id', '=', 'dp_items.item_id')
            ->where('role_id', $role_id)
            ->paginate(10);

        $key = "history_url:{$role_id}";
        $history_url = Redis::get($key);

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'bag_list' => $bag_list,
            'search' => $search,
            'history_url' => $history_url,
        ];
        return view('item_bag', $data);
    }

    public function wear(Request $request)
    {
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $item_id = $request->input('item_id');
        $e_position = $request->input('e_position');
        $id = $request->input('id');

        // 开启事务
        DB::beginTransaction();

        try {
            // 查询玩家背包是否有这个装备
            $check = DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('item_id', $item_id)->first();
            if (!$check) {
                return response()->json(['success' => false, 'msg' => '装备不存在']);
            }

            // 查装备属性
            $equip_info = DB::table('dp_equip_attribute')->where('item_id', $item_id)->first();
            if (!$equip_info) {
                throw new \Exception('装备属性不存在');
            }

            // 查找当前装备在指定位置
            $current_equip = DB::table('dp_roles_equip')->where('role_id', $role_id)->where('e_position', $e_position)->first();

            // 初始化当前装备属性默认值为0
            $current_equip_info = (object) [
                'e_hp' => 0,
                'e_min_gjl' => 0,
                'e_max_gjl' => 0,
                'e_fyl' => 0,
                'e_sd' => 0,
                'e_bj' => 0,
                'e_bjxs' => 0,
                'e_mb' => 0,
                'e_xx' => 0,
            ];

            if (!empty($current_equip->item_id)) {
                // 查当前装备的属性
                $current_equip_info = DB::table('dp_equip_attribute')->where('item_id', $current_equip->item_id)->first();

                // 将当前装备放回背包，并更新status为1
                DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('item_id', $current_equip->item_id)->update(['status' => 1]);
            }

            // 更新装备信息
            $res = DB::table('dp_roles_equip')->where('role_id', $role_id)->where('e_position', $e_position)->update([
                'e_bag_id' => $id,
                'item_id' => $item_id,
                'suit_id' => $equip_info->suit_id,
                'updated_at' => now()
            ]);
            if (!$res) {
                throw new \Exception('更新装备失败');
            } else {
                // 更新背包状态
                DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('id', $id)->update(['status' => 0]);
            }

            // 判断是否穿齐套装
            $suit_id_check = DB::table('dp_roles_equip')
                ->select('suit_id')
                ->where('role_id', $role_id)
                ->whereIn('e_position', [1, 2, 4, 5])
                ->groupBy('suit_id')
                ->havingRaw('COUNT(DISTINCT e_position) = 4')
                ->first();

            // 初始化套装属性默认值为0
            $suit_info = (object) [
                's_hp' => 0,
                's_min_gjl' => 0,
                's_max_gjl' => 0,
                's_fyl' => 0,
                's_sd' => 0,
                's_bj' => 0,
                's_bjxs' => 0,
                's_mb' => 0,
                's_xx' => 0,
            ];

            if (!empty($suit_id_check->suit_id)) {
                // 如果穿齐套装，则查询套装属性
                $suit_info = DB::table('dp_equip_suit')->where('suit_id', $suit_id_check->suit_id)->first();
            }

            // 更新角色属性，先减去当前装备的属性，再加上新装备的属性
            DB::table('dp_roles_attribute')->where('r_id', $role_id)->update([
                'r_now_hp' => DB::raw('r_now_hp - ' . $current_equip_info->e_hp . ' + ' . ($equip_info->e_hp + $suit_info->s_hp)),
                'r_hp' => DB::raw('r_hp - ' . $current_equip_info->e_hp . ' + ' . ($equip_info->e_hp + $suit_info->s_hp)),
                'r_min_gjl' => DB::raw('r_min_gjl - ' . $current_equip_info->e_min_gjl . ' + ' . ($equip_info->e_min_gjl + $suit_info->s_min_gjl)),
                'r_max_gjl' => DB::raw('r_max_gjl - ' . $current_equip_info->e_max_gjl . ' + ' . ($equip_info->e_max_gjl + $suit_info->s_max_gjl)),
                'r_fyl' => DB::raw('r_fyl - ' . $current_equip_info->e_fyl . ' + ' . ($equip_info->e_fyl + $suit_info->s_fyl)),
                'r_sd' => DB::raw('r_sd - ' . $current_equip_info->e_sd . ' + ' . ($equip_info->e_sd + $suit_info->s_sd)),
                'r_bj' => DB::raw('r_bj - ' . $current_equip_info->e_bj . ' + ' . ($equip_info->e_bj + $suit_info->s_bj)),
                'r_bjxs' => DB::raw('r_bjxs - ' . $current_equip_info->e_bjxs . ' + ' . ($equip_info->e_bjxs + $suit_info->s_bjxs)),
                'r_mb' => DB::raw('r_mb - ' . $current_equip_info->e_mb . ' + ' . ($equip_info->e_mb + $suit_info->s_mb)),
                'r_xx' => DB::raw('r_xx - ' . $current_equip_info->e_xx . ' + ' . ($equip_info->e_xx + $suit_info->s_xx)),
            ]);

            // 提交事务
            DB::commit();

            return response()->json(['success' => true, 'msg' => '已装备']);
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();

            return response()->json(['success' => false, 'msg' => '服务器异常', 'error' => $e->getMessage()]);
        }
    }

    public function takeOff(Request $request)
    {
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $item_id = $request->input('item_id');
        $e_position = $request->input('e_position');
        $id = $request->input('id'); // 假设这是背包中的装备ID

        // 开启事务
        DB::beginTransaction();

        try {
            // 查询当前装备
            $current_equip = DB::table('dp_roles_equip')
                ->where('role_id', $role_id)
                ->where('e_position', $e_position)
                ->first();

            if (!$current_equip) {
                return response()->json(['success' => false, 'msg' => '装备不存在']);
            }

            // 查找当前装备属性
            $equip_info = DB::table('dp_equip_attribute')->where('item_id', $current_equip->item_id)->first();
            if (!$equip_info) {
                throw new \Exception('装备属性不存在');
            }

            // 判断是否穿齐套装
            $suit_id_check = DB::table('dp_roles_equip')
                ->select('suit_id')
                ->where('role_id', $role_id)
                ->whereIn('e_position', [1, 2, 4, 5])
                ->groupBy('suit_id')
                ->havingRaw('COUNT(DISTINCT e_position) = 4')
                ->first();

            // 初始化套装属性默认值为0
            $suit_info = (object) [
                's_hp' => 0,
                's_min_gjl' => 0,
                's_max_gjl' => 0,
                's_fyl' => 0,
                's_sd' => 0,
                's_bj' => 0,
                's_bjxs' => 0,
                's_mb' => 0,
                's_xx' => 0,
            ];

            if (!empty($suit_id_check->suit_id)) {
                // 如果穿齐套装，则查询套装属性
                $suit_info = DB::table('dp_equip_suit')->where('suit_id', $suit_id_check->suit_id)->first();
            }

            // 计算新的生命值
            $new_now_hp = DB::table('dp_roles_attribute')->where('r_id', $role_id)->value('r_now_hp') - $equip_info->e_hp - $suit_info->s_hp;
            $new_now_hp = max(1, $new_now_hp);

            // 更新角色属性，减去当前装备和套装的属性
            DB::table('dp_roles_attribute')->where('r_id', $role_id)->update([
                'r_now_hp' => $new_now_hp,
                'r_hp' => DB::raw('r_hp - ' . $equip_info->e_hp . ' - ' . $suit_info->s_hp),
                'r_min_gjl' => DB::raw('r_min_gjl - ' . $equip_info->e_min_gjl . ' - ' . $suit_info->s_min_gjl),
                'r_max_gjl' => DB::raw('r_max_gjl - ' . $equip_info->e_max_gjl . ' - ' . $suit_info->s_max_gjl),
                'r_fyl' => DB::raw('r_fyl - ' . $equip_info->e_fyl . ' - ' . $suit_info->s_fyl),
                'r_sd' => DB::raw('r_sd - ' . $equip_info->e_sd . ' - ' . $suit_info->s_sd),
                'r_bj' => DB::raw('r_bj - ' . $equip_info->e_bj . ' - ' . $suit_info->s_bj),
                'r_bjxs' => DB::raw('r_bjxs - ' . $equip_info->e_bjxs . ' - ' . $suit_info->s_bjxs),
                'r_mb' => DB::raw('r_mb - ' . $equip_info->e_mb . ' - ' . $suit_info->s_mb),
                'r_xx' => DB::raw('r_xx - ' . $equip_info->e_xx . ' - ' . $suit_info->s_xx),
            ]);

            // 更新背包状态，把装备放回背包
            DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('item_id', $item_id)->update(['status' => 1]);

            // 更新装备信息，将item_id置为空
            DB::table('dp_roles_equip')->where('role_id', $role_id)->where('e_position', $e_position)->update(['item_id' => null, 'suit_id' => null, 'e_bag_id' => null, 'updated_at' => now()]);

            // 提交事务
            DB::commit();

            return response()->json(['success' => true, 'msg' => '装备已脱下']);
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();

            return response()->json(['success' => false, 'msg' => '服务器异常', 'error' => $e->getMessage()]);
        }
    }

    public function sell(Request $request)
    {
        $user    = Auth::user();
        $role_id = $user->role->role_id;
        $id      = $request->input('id');
        $type    = $request->input('type');
        $item_id = $request->input('item_id');
        $sell_type = $request->input('sell_type', '1'); // 1装备 2道具

        switch ($sell_type) {
            case 1:
                // 开启事务
                DB::beginTransaction();

                try {
                    // 查询玩家背包是否有这个装备
                    $check = DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('id', $id)->first();
                    if (!$check) {
                        return response()->json(['success' => false, 'msg' => '物品不存在']);
                    }

                    if ($type == 1) { // 售卖
                        $item_info = DB::table('dp_items')->where('item_id', $item_id)->first();

                        // 删除装备
                        $res = DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('id', $id)->delete();
                        if ($res) {
                            // 增加金币
                            $res = DB::table('dp_roles')->where('role_id', $role_id)->increment('gold_coin', $item_info->gold_coin);
                            if ($res) {
                                // 提交事务
                                DB::commit();
                                return response()->json(['success' => true, 'msg' => '售卖成功，获得' . $item_info->gold_coin . '金币']);
                            } else {
                                // 回滚事务
                                DB::rollBack();
                                return response()->json(['success' => false, 'msg' => '服务器异常']);
                            }
                        } else {
                            // 回滚事务
                            DB::rollBack();
                            return response()->json(['success' => false, 'msg' => '服务器异常']);
                        }
                    } else { // 丢弃
                        // 删除装备
                        $res = DB::table('dp_roles_equip_bag')->where('role_id', $role_id)->where('id', $id)->delete();
                        if ($res) {
                            // 提交事务
                            DB::commit();
                            return response()->json(['success' => true, 'msg' => '已丢弃']);
                        } else {
                            // 回滚事务
                            DB::rollBack();
                            return response()->json(['success' => false, 'msg' => '服务器异常']);
                        }
                    }
                } catch (\Exception $e) {
                    // 回滚事务
                    DB::rollBack();
                    return response()->json(['success' => false, 'msg' => '服务器异常', 'error' => $e->getMessage()]);
                }
            case 2:
                // 开启事务
                DB::beginTransaction();

                try {
                    // 查询玩家背包是否有这个道具
                    $check = DB::table('dp_roles_item_bag')->where('role_id', $role_id)->where('id', $id)->first();
                    if (!$check) {
                        return response()->json(['success' => false, 'msg' => '道具不存在']);
                    }

                    if ($type == 1) { // 售卖
                        $item_info = DB::table('dp_items')->where('item_id', $item_id)->first();

                        // 更新道具背包，扣减道具数量
                        if ($check->num > 1) {
                            $res = DB::table('dp_roles_item_bag')->where('id', $check->id)->decrement('num');
                        } else {
                            // 删除道具
                            $res = DB::table('dp_roles_item_bag')->where('id', $check->id)->delete();
                        }

                        if ($res) {
                            // 增加金币
                            $res = DB::table('dp_roles')->where('role_id', $role_id)->increment('gold_coin', $item_info->gold_coin);
                            if ($res) {
                                // 提交事务
                                DB::commit();
                                return response()->json(['success' => true, 'msg' => '售卖成功，获得' . $item_info->gold_coin . '金币']);
                            } else {
                                // 回滚事务
                                DB::rollBack();
                                return response()->json(['success' => false, 'msg' => '服务器异常']);
                            }
                        } else {
                            // 回滚事务
                            DB::rollBack();
                            return response()->json(['success' => false, 'msg' => '服务器异常']);
                        }
                    } else { // 丢弃
                        // 删除道具
                        $res = DB::table('dp_roles_item_bag')->where('id', $check->id)->delete();
                        if ($res) {
                            // 提交事务
                            DB::commit();
                            return response()->json(['success' => true, 'msg' => '已丢弃']);
                        } else {
                            // 回滚事务
                            DB::rollBack();
                            return response()->json(['success' => false, 'msg' => '服务器异常']);
                        }
                    }
                } catch (\Exception $e) {
                    // 回滚事务
                    DB::rollBack();
                    return response()->json(['success' => false, 'msg' => '服务器异常', 'error' => $e->getMessage()]);
                }
        }
        return response()->json(['success' => false, 'msg' => '服务器异常']);
    }

    public function useItem(Request $request)
    {
        $user    = Auth::user();
        $role_id = $user->role->role_id;
        $item_id = $request->input('item_id');

        // 开启事务
        DB::beginTransaction();

        try {
            // 查询道具信息
            $item_info = DB::table('dp_recover_items')->where('item_id', $item_id)->first();
            if (!$item_info) {
                return response()->json(['success' => false, 'msg' => '什么也没有发生']);
            }

            // 查询道具背包信息
            $item_bag = DB::table('dp_roles_item_bag')->where('role_id', $role_id)->where('item_id', $item_id)->first();
            if (!$item_bag || $item_bag->num == 0) {
                return response()->json(['success' => false, 'msg' => '背包中没有该道具']);
            }

            if ($item_info->recover_type == 1) { // 恢复血量
                // 查询角色当前生命值和最大生命值
                $role = DB::table('dp_roles_attribute')->where('r_id', $role_id)->first();

                if ($role) {
                    $new_hp = min($role->r_now_hp + $item_info->hp, $role->r_hp);

                    // 更新角色当前生命值
                    DB::table('dp_roles_attribute')->where('r_id', $role_id)->update([
                        'r_now_hp' => $new_hp
                    ]);

                    // 更新道具背包，扣除道具数量
                    if ($item_bag->num > 1) {
                        DB::table('dp_roles_item_bag')->where('id', $item_bag->id)->decrement('num');
                    } else {
                        DB::table('dp_roles_item_bag')->where('id', $item_bag->id)->delete();
                    }

                    // 提交事务
                    DB::commit();
                    return response()->json(['success' => true, 'msg' => '使用成功，恢复了 ' . $item_info->hp . ' 点血量']);
                } else {
                    DB::rollBack();
                    return response()->json(['success' => false, 'msg' => '角色信息不存在']);
                }
            } elseif ($item_info->recover_type == 3) { // 持续恢复血量
                $check = DB::table('dp_tlb')->where('role_id', $role_id)->first();
                if (!$check) {
                    $res = DB::table('dp_tlb')->insert([
                        'role_id' => $role_id, 'item_id' => $item_id,
                        'hp' => $item_info->all_hp
                    ]);
                    if ($res) {
                        // 更新道具背包，扣除道具数量
                        if ($item_bag->num > 1) {
                            DB::table('dp_roles_item_bag')->where('id', $item_bag->id)->decrement('num');
                        } else {
                            DB::table('dp_roles_item_bag')->where('id', $item_bag->id)->delete();
                        }
                        return response()->json(['success' => true, 'msg' => '使用成功']);
                    }
                } else {
                    if ($item_id != $check->item_id) {
                        $res = DB::table('dp_tlb')
                            ->where('role_id', $role_id)
                            ->update([
                                'hp' => $item_info->all_hp,
                                'item_id' => $item_id,
                            ]);
                    } else {
                        $res = DB::table('dp_tlb')
                            ->where('role_id', $role_id)
                            ->update([
                                'hp' => DB::raw('hp + ' . $item_info->all_hp),
                                'item_id' => $item_id,
                            ]);
                    }
                    if ($res) {
                        // 更新道具背包，扣除道具数量
                        if ($item_bag->num > 1) {
                            DB::table('dp_roles_item_bag')->where('id', $item_bag->id)->decrement('num');
                        } else {
                            DB::table('dp_roles_item_bag')->where('id', $item_bag->id)->delete();
                        }
                        return response()->json(['success' => true, 'msg' => '使用成功']);
                    }
                }
            } else {
                return response()->json(['success' => false, 'msg' => '什么也没有发生']);
            }
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => '服务器异常', 'error' => $e->getMessage()]);
        }
    }

}
