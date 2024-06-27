<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header"><a href="javascript:void(0);" onclick="location.reload();" class="o-bt">刷新</a> <a href="javascript:void(0);" class="o-bt">任务</a></div>
        <div class="layui-card-body">
            @if ($type == 1 && !empty($equip_info))
                <div class="room-description">
                    <p style="color: {{ $equip_info->color }}">{{ $equip_info->item_name }}</p>
                    <p>描述：{{ $equip_info->desc }}</p>
                </div>
                <div class="room-actions">
                    <img width="60px" src="{{ $equip_info->pic }}"  alt=""/>
                </div>

                <div class="room-actions">
                    <p>生命：+{{ $equip_info->e_hp }}</p>
                    <p>最小攻击：+{{ $equip_info->e_min_gjl }}</p>
                    <p>最大攻击：+{{ $equip_info->e_max_gjl }}</p>
                    <p>防御：+{{ $equip_info->e_fyl }}</p>
                    <p>敏捷：+{{ $equip_info->e_sd }}</p>
                    <p>麻痹率：+{{ $equip_info->e_mb }}%</p>
                    <p>暴击率：+{{ $equip_info->e_bj }}%</p>
                    <p>暴击系数：+{{ $equip_info->e_bjxs }}</p>
                    <p>吸血率：+{{ $equip_info->e_xx }}%</p>
                </div>
            @elseif ($type == 2 && !empty($item_info))
                <div class="room-description">
                    <p style="color: {{ $item_info->color }}">{{ $item_info->item_name }}</p>
                    <p>描述：{{ $item_info->desc }}</p>
                </div>
                <div class="room-actions">
                    <img width="60px" src="{{ $item_info->pic }}"  alt=""/>
                </div>

                @if ($item_info->recover_type == 1)
                    <div class="room-actions">
                        <p>功效：</p>
                        <p>生命回复：+{{ $item_info->hp }}</p>
                    </div>
                @endif
            @endif
            <p>
                <a href="javascript:void(0);" class="o-bt" onclick="history.back();">返回游戏</a>
            </p>
        </div>
    </div>
    <!-- 页尾部分 -->
    @include('layouts.footer')
