<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header"><a href="javascript:void(0);" onclick="location.reload();" class="o-bt">刷新</a> <a href="javascript:void(0);" class="o-bt">任务</a></div>
        <div class="layui-card-body">
            <div class="room-description">
                {{ $roles_info->realm_desc }}
            </div>
            <div class="room-actions">
                <p>境界：{{ $roles_info->realm_name }}</p>
                <p>等级：{{ $roles_info->r_level }}</p>
                <p>经验：{{ $roles_info->r_exp }}/{{ $roles_info->next_level_exp }}</p>
                <p>生命：{{ $roles_info->r_now_hp }}/{{ $roles_info->r_hp }}</p>
                <p>最小攻击：{{ $roles_info->r_min_gjl }}</p>
                <p>最大攻击：{{ $roles_info->r_max_gjl }}</p>
                <p>防御：{{ $roles_info->r_fyl }}</p>
                <p>敏捷：{{ $roles_info->r_sd }}</p>
                <p>麻痹率：{{ $roles_info->r_mb }}%</p>
                <p>暴击率：{{ $roles_info->r_bj }}%</p>
                <p>暴击系数：{{ $roles_info->r_bjxs }}</p>
                <p>吸血率：{{ $roles_info->r_xx }}%</p>
            </div>

            <div class="room-actions">
                <p>头戴：@if(!$equip_arr[1]['item_name']) 无 @else<span style="color: {{ $equip_arr[1]['color'] }}">★*+{{ $equip_arr[1]['e_quality'] }}の{{ $equip_arr[1]['item_name'] }}({{ $equip_arr[1]['e_level'] }}级)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOff({{ $equip_arr[1]['item_id'] }}, 1)">解除</a>@endif</p>
                <p>身穿：@if(!$equip_arr[2]['item_name']) 无 @else<span style="color: {{ $equip_arr[2]['color'] }}">★*+{{ $equip_arr[2]['e_quality'] }}の{{ $equip_arr[2]['item_name'] }}({{ $equip_arr[2]['e_level'] }}级)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOff({{ $equip_arr[2]['item_id'] }}, 2)">解除</a>@endif</p>
                <p>手持：@if(!$equip_arr[3]['item_name']) 无 @else<span style="color: {{ $equip_arr[3]['color'] }}">★*+{{ $equip_arr[3]['e_quality'] }}の{{ $equip_arr[3]['item_name'] }}({{ $equip_arr[3]['e_level'] }}级)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOff({{ $equip_arr[3]['item_id'] }}, 3)">解除</a>@endif</p>
                <p>腰戴：@if(!$equip_arr[4]['item_name']) 无 @else<span style="color: {{ $equip_arr[4]['color'] }}">★*+{{ $equip_arr[4]['e_quality'] }}の{{ $equip_arr[4]['item_name'] }}({{ $equip_arr[4]['e_level'] }}级)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOff({{ $equip_arr[4]['item_id'] }}, 4)">解除</a>@endif</p>
                <p>脚穿：@if(!$equip_arr[5]['item_name']) 无 @else<span style="color: {{ $equip_arr[5]['color'] }}">★*+{{ $equip_arr[5]['e_quality'] }}の{{ $equip_arr[5]['item_name'] }}({{ $equip_arr[5]['e_level'] }}级)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOff({{ $equip_arr[5]['item_id'] }}, 5)">解除</a>@endif</p>
                <p>饰品：@if(!$equip_arr[6]['item_name']) 无 @else<span style="color: {{ $equip_arr[6]['color'] }}">★*+{{ $equip_arr[6]['e_quality'] }}の{{ $equip_arr[6]['item_name'] }}({{ $equip_arr[6]['e_level'] }}级)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOff({{ $equip_arr[6]['item_id'] }}, 6)">解除</a>@endif</p>
                <p>药品：
                    @if(!$tlb_info)
                        无
                    @else
                        @if ($tlb_info->status == 0)
                            无 <a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOffTlb(1)">穿戴</a>
                        @else
                            <span style="color: {{ $tlb_info->color }}">★*+{{ $tlb_info->item_name }}(剩余{{ $tlb_info->hp }}血)</span><a href="javascript:void(0);" class="o-bt" style="margin-left: 10px" onclick="takeOffTlb(0)">解除</a>
                        @endif
                    @endif
                </p>
            </div>

            @if ($suit_info)
            <div class="room-actions">
                <p style="color: #FFB800">卍{{ $suit_info->suit_name }}:</p>
                <p class="o-bt">生命 +{{ $suit_info->s_hp }}</p>
                <p class="o-bt">最小攻击 +{{ $suit_info->s_min_gjl }}</p>
                <p class="o-bt">最大攻击 +{{ $suit_info->s_max_gjl }}</p>
                <p class="o-bt">防御 +{{ $suit_info->s_fyl }}</p>
                <p class="o-bt">敏捷 +{{ $suit_info->s_sd }}</p>
                <p class="o-bt">麻痹攻 +{{ $suit_info->s_mb }}%</p>
                <p class="o-bt">暴击率 +{{ $suit_info->s_bj }}%</p>
                <p class="o-bt">吸血 +{{ $suit_info->s_xx }}%</p>
            </div>
            @endif

            <p>
                <a href="javascript:void(0);" onclick="history.back();">返回游戏</a>
            </p>
        </div>
    </div>
    <!-- 页尾部分 -->
    @include('layouts.footer')
    <script>
        function takeOff(item_id, e_position) {
            $.ajax({
                url: '/take_off',
                type: 'POST',
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
                },
                data: JSON.stringify({item_id: item_id, e_position: e_position}),
                success: function (data) {
                    if (data.success) {
                        layer.msg(data.msg)
                        setTimeout(function() {
                            window.location.reload()
                        }, 800); // 延迟1秒 (1000毫秒)
                    } else {
                        layer.msg(data.msg)
                    }
                }
            })
        }

        function takeOffTlb(status) {
            $.ajax({
                url: '/take_off_tlb',
                type: 'POST',
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
                },
                data: JSON.stringify({status: status}),
                success: function (data) {
                    if (data.success) {
                        layer.msg(data.msg)
                        setTimeout(function() {
                            window.location.reload()
                        }, 800); // 延迟1秒 (1000毫秒)
                    } else {
                        layer.msg(data.msg)
                    }
                }
            })
        }
    </script>
