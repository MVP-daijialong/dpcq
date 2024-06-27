<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header"><a href="javascript:void(0);" onclick="location.reload();" class="o-bt">刷新</a> <a href="javascript:void(0);" class="o-bt">任务</a></div>
        <div class="layui-card-body">
            <div class="room-description">
                {{ $target_info->target_des }}
            </div>
            <div class="room-actions">
                <img width="60px" src="{{ $target_info->target_pic }}"  alt=""/>
            </div>
            <div class="room-actions">
                <p>境界：{{ $target_info->realm_name }}</p>
                <p>名称：{{ $target_info->target_name }}</p>
                <p>等级：{{ $target_info->t_level }}</p>
                <p>生命：{{ $target_info->t_hp }}</p>
                <p>最小攻击：{{ $target_info->t_min_gjl }}</p>
                <p>最大攻击：{{ $target_info->t_max_gjl }}</p>
                <p>防御：{{ $target_info->t_fyl }}</p>
                <p>敏捷：{{ $target_info->t_sd }}</p>
                <p>麻痹率：{{ $target_info->t_mb }}%</p>
                <p>暴击率：{{ $target_info->t_bj }}%</p>
                <p>暴击系数：{{ $target_info->t_bjxs }}</p>
                <p>吸血率：{{ $target_info->t_xx }}%</p>
            </div>

            <p>
                <a href="javascript:void(0);" class="o-bt" onclick="history.back();">返回游戏</a>
            </p>
        </div>
    </div>
    <!-- 页尾部分 -->
    @include('layouts.footer')
