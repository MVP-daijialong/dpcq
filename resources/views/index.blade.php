<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header">{{ $main_map->map_name }} | <a href="javascript:void(0);" onclick="location.reload();" class="o-bt">刷新</a> <a href="javascript:void(0);" class="o-bt">任务</a></div>
        <div class="layui-card-body">
            <div class="room-description">
                {{ $main_map->map_desc }}
            </div>
            <div class="room-actions">
                <p>你看到：</p>
                <div class="see-list">
                    @if ($target_list)
                        @foreach($target_list as $item)
                            @for ($i = 1; $i <= $item->num; $i++)
                                <a href="javascript:void(0);" onclick="jump_target_info({{ $item->map_id }}, {{ $item->id }})" class="o-bt" @if ($item->target_type == 2)style="color:#FFB800"@endif>{{ $item->target_name }}</a>
                            @endfor
                        @endforeach
                    @else
                        <p>空空如也~~</p>
                    @endif
                </div>
            </div>
            <div class="room-actions">
                <p>请选择出口：</p>
                <div class="see-list">
                    @if ($branch_map)
                        @foreach ($branch_map as $item)
                            <a href="javascript:void(0);" class="o-bt" onclick="jump_map({{ $item->map_id }}, {{ $item->pid }})">{{ $item->map_name }}</a>
                        @endforeach
                            @if ($pid != 0)<a href="javascript:void(0);" class="o-bt" onclick="return_map({{ $pid }})">返回</a>@endif
                    @else
                        @if ($pid != 0)<a href="javascript:void(0);" class="o-bt" onclick="return_map({{ $pid }})">返回</a>@endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- 页尾部分 -->
    @include('layouts.footer')
