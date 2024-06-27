<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $map_id = $request->input('map_id', 1);
        $pid = $request->input('pid', 0);
        $now_time = date("H:i", time());

        // 获取主地图
        $main_map = DB::table('dp_map')->where('map_id', $map_id)->where('pid', $pid)->first();
        if (empty($main_map)) {
            echo "<!DOCTYPE html>
                <html>
                <head>
                    <meta charset='utf-8'>
                    <title>Layui Example</title>
                    <!-- 引入 Layui 的 CSS 文件 -->
                    <link rel='stylesheet' href='/layui/css/layui.css'>
                </head>
                <body>
                    <!-- 引入 Layui 的 JS 文件 -->
                    <script src='/layui/layui.js'></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            layer.msg('地图参数错误!', {icon: 5, time: 2000}, function() {
                                history.back();
                            });
                        });
                    </script>
                </body>
                </html>";
            exit;
        }
        // 获取分支地图
        $branch_map = DB::table('dp_map')->where('pid', $map_id)->get()->toArray();

        // 获取人物
        $target_list = DB::table('dp_attack_target')->where('map_id', $map_id)->get()->toArray();

        // 存储路径
        $user = Auth::user();
        $role_id = $user->role->role_id;
        $key = "history_url:{$role_id}";
        $history_url = "/index?map_id={$map_id}&pid={$pid}";
        Redis::set($key, $history_url);

        $data = [
            'is_show_map' => 0,
            'now_time' => $now_time,
            'main_map' => $main_map,
            'branch_map' => $branch_map,
            'target_list' => $target_list,
            'pid' => $pid,
            'history_url' => $history_url,
        ];
        return view('index', $data);
    }

    public function targetInfo(Request $request)
    {
        $map_id = $request->input('map_id', 1);
        $id = $request->input('id', 0);
        $now_time = date("H:i", time());

        $user = Auth::user();
        $role_id = $user->role->role_id;
        $redisKey = "battle_status:$role_id:$id";

        // 获取分支地图
        $branch_map = DB::table('dp_map')->where('pid', $map_id)->get()->toArray();

        // 清除 Redis 中的战斗状态
        Redis::del($redisKey);

        $target_info = DB::table('dp_attack_target')->where('id', $id)->where('map_id', $map_id)->first();
        if (empty($target_info)) {
            echo "<!DOCTYPE html>
                <html>
                <head>
                    <meta charset='utf-8'>
                    <title>Layui Example</title>
                    <!-- 引入 Layui 的 CSS 文件 -->
                    <link rel='stylesheet' href='/layui/css/layui.css'>
                </head>
                <body>
                    <!-- 引入 Layui 的 JS 文件 -->
                    <script src='/layui/layui.js'></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            layer.msg('地图参数错误!', {icon: 5, time: 2000}, function() {
                                history.back();
                            });
                        });
                    </script>
                </body>
                </html>";
            exit;
        }
        if ($target_info->target_type == 4) {
            $pid = $request->input('pid', 0);
            // 获取对话
            $duihua_list = DB::table('dp_duihua')->where('t_id', $id)->where('pid', $pid)->get()->toArray();
            return view('target_npc_info', [
                'target_info' => $target_info, 'now_time' => $now_time,
                'duihua_list' => $duihua_list, 'pid' => $pid,
                'is_show_map' => 1, 'branch_map' => $branch_map
            ]);
        }

        // 查属性值
        $attribute_info = DB::table('dp_attribute')->where('t_id', $id)->first();

        // 查角色
        $roles_info = DB::table('dp_roles')
            ->select('dp_roles.role_id', 'dp_roles.role_name', 'dp_roles_attribute.*')
            ->leftJoin('dp_roles_attribute', 'dp_roles.role_id', '=', 'dp_roles_attribute.r_id')
            ->where('role_id', $role_id)
            ->first();

        $data = [
            'is_show_map' => 1,
            'now_time' => $now_time,
            'target_info' => $target_info,
            'attribute_info' => $attribute_info,
            'roles_info' => $roles_info,
            'branch_map' => $branch_map,
        ];
        return view('target_info', $data);
    }

    public function attack(Request $request)
    {
        $role_id = $request->input('roleId');
        $target_id = $request->input('targetId');

        // 获取角色和目标的属性
        $role = DB::table('dp_roles')
            ->select('dp_roles.role_id', 'dp_roles.role_name', 'dp_roles_attribute.*')
            ->leftJoin('dp_roles_attribute', 'dp_roles.role_id', '=', 'dp_roles_attribute.r_id')
            ->where('role_id', $role_id)
            ->first();

        $target = DB::table('dp_attack_target')->select('dp_attack_target.target_name', 'dp_attribute.*')
            ->leftJoin('dp_attribute', 'dp_attack_target.id', '=', 'dp_attribute.t_id')
            ->where('dp_attack_target.id', $target_id)
            ->first();

        if (!$role || !$target) {
            return response()->json(['success' => false, 'message' => '角色或目标不存在']);
        }

        // 获取或设置 Redis 键和过期时间
        $redisKey = "battle_status:$role_id:$target_id";
        $expiration = 60; // 这里设置为60秒，可以根据实际需求调整

        // 获取目标当前生命值，如果不存在则初始化为初始值
        $currentTargetHp = Redis::get($redisKey);
        if (!$currentTargetHp) {
            Redis::setex($redisKey, $expiration, $target->t_hp);
            $currentTargetHp = $target->t_hp;
        }

        // 初始化麻痹状态
        $roleParalyzed = false;
        $targetParalyzed = false;

        // 记录战斗细节
        $battleDetails = [];

        // 角色攻击目标
        $roleAttacks = $this->calculateAttacks($role->r_sd, $target->t_sd);
        for ($i = 0; $i < $roleAttacks; $i++) {
            if (!$roleParalyzed) {
                $damage = $this->calculateDamage(
                    $role->r_min_gjl,
                    $role->r_max_gjl,
                    $role->r_bj,
                    $role->r_bjxs,
                    $target->t_fyl
                );

                // 吸血效果
                $heal = $damage * ($role->r_xx / 100);
                $newRoleHp = min($role->r_now_hp + $heal, $role->r_hp); // 生命值不能超过最大值
                $newRoleHp = max($newRoleHp, 0);
                DB::table("dp_roles_attribute")->where('r_id', $role_id)->update(['r_now_hp' => $newRoleHp]);

                // 更新目标生命值
                if ($damage > 0) {
                    $currentTargetHp -= $damage;
                    Redis::setex($redisKey, $expiration, $currentTargetHp);
                }

                // 麻痹效果
                if (rand(0, 100) < $role->r_mb) {
                    $targetParalyzed = true;
                }

                // 添加战斗详情
                $battleDetails[] = [
                    'target_now_hp' => $currentTargetHp,
                    'role_id' => $role_id,
                    'attacker' => $role->role_name,
                    'attack' => '攻击',
                    'target' => $target->target_name,
                    'damage' => $damage,
                    'heal' => $heal,
                    'paralyzed' => $targetParalyzed
                ];

                if ($currentTargetHp <= 0) {
                    break;
                }
            } else {
                $battleDetails[] = [
                    'target_now_hp' => $currentTargetHp,
                    'role_id' => $role_id,
                    'attacker' => $role->role_name,
                    'attack' => '被麻痹',
                    'target' => $target->target_name,
                    'damage' => 0,
                    'heal' => 0,
                    'paralyzed' => $roleParalyzed
                ];
            }
        }

        // 目标攻击角色
        if (!$targetParalyzed && $currentTargetHp > 0) {
            $targetAttacks = $this->calculateAttacks($target->t_sd, $role->r_sd);
            for ($i = 0; $i < $targetAttacks; $i++) {
                $damage = $this->calculateDamage(
                    $target->t_min_gjl,
                    $target->t_max_gjl,
                    $target->t_bj,
                    $target->t_bjxs,
                    $role->r_fyl
                );

                // 吸血效果
                $heal = $damage * ($target->t_xx / 100);
                $currentTargetHp = min($currentTargetHp + $heal, $target->t_hp); // 生命值不能超过最大值
                Redis::setex($redisKey, $expiration, $currentTargetHp);

                // 更新角色当前生命值
                if ($damage > 0) {
                    $newHp = max(0, $role->r_now_hp - $damage);
                    DB::table('dp_roles_attribute')->where('r_id', $role_id)->update(['r_now_hp' => $newHp]);
                }

                // 麻痹效果
                if (rand(0, 100) < $target->t_mb) {
                    $roleParalyzed = true;
                }

                // 添加战斗详情
                $battleDetails[] = [
                    'target_now_hp' => $currentTargetHp,
                    'role_id' => $role_id,
                    'attacker' => $target->target_name,
                    'attack' => '攻击',
                    'target' => $role->role_name,
                    'damage' => $damage,
                    'heal' => $heal,
                    'paralyzed' => $roleParalyzed
                ];

                if ($damage > 0) {
                    // 自动回复生命值逻辑
                    $tlb_info = DB::table('dp_tlb')
                        ->select('dp_tlb.*', 'dp_items.item_name')
                        ->leftJoin('dp_items', 'dp_tlb.item_id', '=', 'dp_items.item_id')
                        ->where('role_id', $role_id)->where('status', 1)->first();
                    if ($newHp < $role->r_hp && $tlb_info) {
                        $recover_info = DB::table('dp_recover_items')->where('item_id', $tlb_info->item_id)->where('recover_type', 3)->first();
                        // 回复生命值
                        $heal = min($role->r_hp - $newHp, $recover_info->hp);
                        DB::table('dp_roles_attribute')->where('r_id', $role_id)->increment('r_now_hp', $heal);

                        // 扣除体力宝
                        DB::table('dp_tlb')->where('role_id', $role_id)->decrement('hp', $recover_info->hp);

                        $battleDetails[] = [
                            'target_now_hp' => $currentTargetHp,
                            'role_id' => $role_id,
                            'attacker'  => $tlb_info->item_name,
                            'attack'    => '回复',
                            'target'    => $role->role_name,
                            'damage'    => -($recover_info->hp),
                            'heal'      => $heal,
                            'paralyzed' => $roleParalyzed
                        ];
                    }
                }

                if ($currentTargetHp <= 0) {
                    break;
                }
            }
        } else if ($currentTargetHp > 0) {
            $battleDetails[] = [
                'target_now_hp' => $currentTargetHp,
                'role_id' => $role_id,
                'attacker' => $target->target_name,
                'attack' => '被麻痹',
                'target' => $role->role_name,
                'damage' => 0,
                'heal' => 0,
                'paralyzed' => $targetParalyzed
            ];
        }

        // 结算战斗，发放经验值和掉落装备
        if ($currentTargetHp <= 0) {
            $exp = 0;
            // 掉落道具
            $drop_items = DB::table('dp_drop as dd')
                ->select('dd.*', 'di.item_name', 'di.color')
                ->leftJoin('dp_items as di', 'dd.item_id', '=', 'di.item_id')
                ->where('t_id', $target_id)
                ->get()
                ->map(function ($item) {
                    return (array) $item;
                })
                ->toArray();

            $equipment = '*获得了'; // 假设掉落的装备为金剑
            foreach ($drop_items as $v) {
                $isDrop = rand(0, 100) <= $v['drop_probability'];
                if (!$isDrop) continue;

                if ($v['item_id'] == 1) {
                    DB::table('dp_roles')->where('role_id', $role_id)->increment('gold_coin', $v['drop_num']);
                }
                if ($v['item_id'] == 2) {
                    $exp = $v['drop_num'];
                }
                $equipment .= "[<span style='color:{$v['color']}'>" . $v['item_name'] . "</span>] *" . $v['drop_num'] . " ,";

                if ($v['drop_type'] == 1) {
                    if ($v['item_id'] == 1 || $v['item_id'] == 2) continue;

                    $item_bag_info = DB::table('dp_roles_item_bag')
                        ->where('role_id', $role_id)
                        ->where('item_id', $v['item_id'])
                        ->first();

                    if ($item_bag_info) {
                        if ($item_bag_info->num > 999) {
                            $equipment .= "[<span style='color:{$v['color']}'>" . $v['item_name'] . "</span>]背包已满, 已丢弃 ,";
                        } else {
                            $num = $item_bag_info->num + $v['drop_num'] > 999 ? 999 : $item_bag_info->num + $v['drop_num'];
                            DB::table('dp_roles_item_bag')
                                ->where('role_id', $role_id)
                                ->where('item_id', $v['item_id'])
                                ->update(['num' => $num]);
                        }
                    } else {
                        DB::table('dp_roles_item_bag')
                            ->insert(['role_id' => $role_id, 'item_id' => $v['item_id'], 'num' => $v['drop_num']]);
                    }
                } elseif ($v['drop_type'] == 2) {
                    $equip_bag_count = DB::table('dp_roles_equip_bag')
                        ->where('role_id', $role_id)
                        ->count();
                    if ($equip_bag_count > 199) {
                        $equipment .= "背包已满, 已丢弃 [<span style='color:{$v['color']}'>" . $v['item_name'] . "</span>]";
                    } else {
                        DB::table('dp_roles_equip_bag')->insert(['role_id' => $role_id, 'item_id' => $v['item_id']]);
                    }
                }
            }

            // 获取当前角色的经验和等级映射关系
            $levelInfo = DB::table('dp_levels')
                ->select('dp_levels.*', 'dp_plevels.level_name as p_name')
                ->leftJoin('dp_plevels', 'dp_levels.pid', '=', 'dp_plevels.level_id')
                ->where('exp', '<=', $role->r_exp + $exp) // 找到小于等于当前经验值+获得经验值的最高等级映射
                ->orderBy('level', 'desc') // 按照等级降序排序，找到最高等级
                ->first();

            $level_text = '';
            if ($levelInfo) {
                // 获取更新前的等级
                $currentLevel = DB::table('dp_roles_attribute')
                    ->where('r_id', $role_id)
                    ->value('r_level');

                // 更新角色属性表中的等级信息
                DB::table('dp_roles_attribute')
                    ->where('r_id', $role_id)
                    ->update([
                        'r_exp' => DB::raw('r_exp + ' . $exp), // 增加经验值
                        'r_level' => $levelInfo->level, // 更新等级
                        'updated_at' => date("Y-m-d H:i:s", time())
                    ]);

                // 获取更新后的等级
                $newLevel = $levelInfo->level;

                // 检查等级是否提升
                if ($newLevel > $currentLevel) {
                    // 基础值（1级的属性）
                    $baseValues = [
                        'hp' => 500,
                        'min_gjl' => 20,
                        'max_gjl' => 30,
                        'fyl' => 12,
                    ];

                    // 每一级的增长率（逐渐递增）
                    $growthRates = [
                        'hp' => 0.05, // 每级增加 5%
                        'min_gjl' => 0.03, // 每级增加 3%
                        'max_gjl' => 0.03, // 每级增加 3%
                        'fyl' => 0.02, // 每级增加 2%
                    ];

                    // 生成2级到168级的成长值
                    $startLevel = 2;
                    $endLevel = 168;
                    $growthValues = $this->generateGrowthValues($startLevel, $endLevel, $baseValues, $growthRates);

                    // 获取新等级的基础属性值
                    $newBaseAttributes = $growthValues[$newLevel];

                    // 查询当前装备和套装的属性加成
                    $equipAttributes = DB::table('dp_roles_equip')
                        ->join('dp_equip_attribute', 'dp_roles_equip.item_id', '=', 'dp_equip_attribute.item_id')
                        ->where('dp_roles_equip.role_id', $role_id)
                        ->select(DB::raw('SUM(dp_equip_attribute.e_hp) as e_hp'),
                            DB::raw('SUM(dp_equip_attribute.e_min_gjl) as e_min_gjl'),
                            DB::raw('SUM(dp_equip_attribute.e_max_gjl) as e_max_gjl'),
                            DB::raw('SUM(dp_equip_attribute.e_fyl) as e_fyl'))
                        ->first();

                    // 初始化套装属性为零
                    $suitAttributes = (object) [
                        's_hp' => 0,
                        's_min_gjl' => 0,
                        's_max_gjl' => 0,
                        's_fyl' => 0,
                    ];

                    // 判断是否穿齐套装
                    $suit_id_check = DB::table('dp_roles_equip')
                        ->select('suit_id')
                        ->where('role_id', $role_id)
                        ->whereIn('e_position', [1, 2, 4, 5])
                        ->groupBy('suit_id')
                        ->havingRaw('COUNT(DISTINCT e_position) = 4')
                        ->first();

                    if (!empty($suit_id_check->suit_id)) {
                        // 如果穿齐套装，则查询套装属性
                        $suitAttributes = DB::table('dp_equip_suit')->where('suit_id', $suit_id_check->suit_id)->first();
                    }

                    // 计算新的总属性值（基础属性 + 装备属性 + 套装属性）
                    $newAttributes = [
                        'hp' => $newBaseAttributes['hp'] + $equipAttributes->e_hp + $suitAttributes->s_hp,
                        'min_gjl' => $newBaseAttributes['min_gjl'] + $equipAttributes->e_min_gjl + $suitAttributes->s_min_gjl,
                        'max_gjl' => $newBaseAttributes['max_gjl'] + $equipAttributes->e_max_gjl + $suitAttributes->s_max_gjl,
                        'fyl' => $newBaseAttributes['fyl'] + $equipAttributes->e_fyl + $suitAttributes->s_fyl,
                    ];

                    // 获取当前角色的现有生命值
                    $currentNowHp = DB::table('dp_roles_attribute')->where('r_id', $role_id)->value('r_now_hp');

                    // 更新角色属性
                    DB::table('dp_roles_attribute')
                        ->where('r_id', $role_id)
                        ->update([
                            'r_hp' => $newAttributes['hp'],
                            'r_min_gjl' => $newAttributes['min_gjl'],
                            'r_max_gjl' => $newAttributes['max_gjl'],
                            'r_fyl' => $newAttributes['fyl'],
                            'r_now_hp' => min($newAttributes['hp'], $currentNowHp), // 保持当前血量在合理范围内
                            'updated_at' => now()
                        ]);

                    $level_name = $levelInfo->p_name . $levelInfo->level_name;
                    $level_text = "*混沌初开, [" . $role->role_name . "]境界突破到<span style='color: #5FB878'>☆" . $level_name . "</span>!";
                }
            }
            $equipment = rtrim($equipment, " ,");
            // 清除 Redis 中的战斗状态
            Redis::del($redisKey);

            return response()->json(['success' => true, 'battleDetails' => $this->formatBattleDetails($battleDetails), 'level_text' => $level_text, 'equipment' => $equipment]);
        }

        // 如果战斗未结束，返回战斗详情
        return response()->json(['success' => true, 'battleDetails' => $this->formatBattleDetails($battleDetails)]);
    }

    private function formatBattleDetails($battleDetails)
    {
        $formattedDetails = [];
        // 查询当前角色生命值
        foreach ($battleDetails as $k => $detail) {
            $roles_info = DB::table('dp_roles_attribute')->where('r_id', $detail['role_id'])->first();
            $formattedDetails[$k]['role_now_hp'] = $roles_info->r_now_hp;
            $formattedDetails[$k]['target_now_hp'] = max($detail['target_now_hp'], 0);
            $formattedDetails[$k]['heal'] = ceil($detail['heal']);
            if ($detail['damage'] > 0) {
                $formattedDetail = "*{$detail['attacker']}使出[<span class='s-attack'>{$detail['attack']}</span>], {$detail['target']}受到[<span class='s-damage'>{$detail['damage']}</span>]伤害";
                if ($detail['heal'] > 0) {
                    $formattedDetail .= ", 吸血+[<span class='s-heal'>" . ceil($detail['heal']) . "</span>]生命值";
                }
                if ($detail['paralyzed']) {
                    $formattedDetail .= ", 附加状态[麻痹]";
                }
                $formattedDetails[$k]['damage'] = $detail['damage'];
                $formattedDetails[$k]['desc'] = $formattedDetail;
            } elseif ($detail['damage'] < 0) {
                $formattedDetails[$k]['damage'] = 0;
                $formattedDetails[$k]['desc'] = "*[{$detail['attacker']}]生效了,{$detail['target']}回复了[<span class='s-heal'>" . ceil(abs($detail['damage'])) . "</span>]生命值";
            } else {
                $formattedDetails[$k]['damage'] = 0;
                if ($detail['paralyzed']) {
                    $formattedDetails[$k]['desc'] = "*{$detail['attacker']}中了[麻痹], 无法动弹！！";
                } else {
                    $formattedDetails[$k]['desc'] = "*{$detail['attacker']}使出[<span class='s-attack'>{$detail['attack']}</span>], {$detail['target']}受到[<span class='s-damage'>0</span>]伤害";
                }
            }
        }
        return $formattedDetails;
    }

    private function calculateAttacks($attackerSpeed, $defenderSpeed)
    {
        $speedRatio = $attackerSpeed / $defenderSpeed;
        if ($speedRatio >= 3) {
            return 2; // 超过两倍速度，攻击两次
        } elseif ($speedRatio >= 1) {
            return rand(0, 100) < ($speedRatio - 1) * 100 ? 2 : 1; // 根据比率计算是否攻击两次
        } else {
            return 1; // 低于速度，没有额外攻击
        }
    }


    private function calculateDamage($minAttack, $maxAttack, $critRate, $critMultiplier, $defense)
    {
        // 基础伤害计算
        $baseDamage = rand($minAttack, $maxAttack);

        // 判断是否暴击
        $isCrit = rand(0, 100) <= $critRate;
        if ($isCrit) {
            $baseDamage = ($baseDamage - $defense) * $critMultiplier;
        } else {
            $baseDamage = $baseDamage - $defense;
        }

        // 确保最终伤害不为负数
        $finalDamage = max($baseDamage, 0);

        return $finalDamage;
    }

    function generateGrowthValues($startLevel, $endLevel, $baseValues, $growthRates)
    {
        $growthValues = [];

        for ($level = $startLevel; $level <= $endLevel; $level++) {
            $hp = $baseValues['hp'] + ($level - 1) * $baseValues['hp'] * $growthRates['hp'];
            $minGjl = $baseValues['min_gjl'] + ($level - 1) * $baseValues['min_gjl'] * $growthRates['min_gjl'];
            $maxGjl = $baseValues['max_gjl'] + ($level - 1) * $baseValues['max_gjl'] * $growthRates['max_gjl'];
            $fyl = $baseValues['fyl'] + ($level - 1) * $baseValues['fyl'] * $growthRates['fyl'];

            $growthValues[$level] = [
                'hp' => round($hp),
                'min_gjl' => round($minGjl),
                'max_gjl' => round($maxGjl),
                'fyl' => round($fyl),
            ];
        }

        return $growthValues;
    }

    public function retreat(Request $request)
    {
        $role_id = $request->input('role_id');
        $target_id = $request->input('target_id');
        $target_info = DB::table('dp_attack_target')->where('id', $target_id)->first('retreat_amount');
        $role_info = DB::table('dp_roles')->where('role_id', $role_id)->first('gold_coin');
        if ($target_info->retreat_amount > $role_info->gold_coin) {
            return response()->json(['success' => false, 'msg' => '金币不够, 无法撤退']);
        }
        $res = DB::table('dp_roles')->where('role_id', $role_id)->decrement('gold_coin', $target_info->retreat_amount);
        if ($res) {
            return response()->json(['success' => true, 'msg' => '撤退成功']);
        } else {
            return response()->json(['success' => false, 'msg' => '服务器异常']);
        }
    }

    public function returnMap(Request $request)
    {
        $pid = $request->input('pid');
        $map_info = DB::table('dp_map')->where('map_id', $pid)->first();
        if (!$map_info) {
            return response()->json(['success' => false, 'msg' => '服务器异常']);
        }

        $url = "/index?map_id=" . $map_info->map_id . '&pid=' . $map_info->pid;

        return response()->json(['success' => true, 'msg' => '跳转成功', 'url' => $url]);
    }
}
