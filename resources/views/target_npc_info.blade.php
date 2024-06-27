<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header"><a href="javascript:void(0);" onclick="history.back();">返回游戏</a> | <a href="javascript:void(0);" onclick="location.reload();" class="o-bt">刷新</a> <a href="javascript:void(0);" class="o-bt">任务</a></div>
        <div class="layui-card-body">
            <div class="room-description">
                {{ $target_info->target_des }}
            </div>
            <div class="room-actions">
                @foreach($duihua_list as $item)
                    <p><a href="javascript:void(0);" @if ($item->click == 1) onclick="jump_duihua_info({{ $target_info->map_id }}, {{ $target_info->id }} , {{ $item->id }})" class="o-bt" @endif>{{ $item->content }}</a></p>
                @endforeach
                    @if ($pid > 0)
                        <p style="margin-top: 15px"><a href="javascript:void(0);" onclick="jump_duihua_info({{ $target_info->map_id }}, {{ $target_info->id }} , 0)">返回</a></p>
                    @endif
            </div>
        </div>
    </div>
    <!-- 页尾部分 -->
@include('layouts.footer')

