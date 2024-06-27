<div class="layui-card">
    <div class="layui-card-body">
        <div class="room-actions">
            @if ($is_show_map)
                <p>【地图导航】</p>
                @foreach ($branch_map as $index => $item)
                    <a href="javascript:void(0);" class="o-bt" onclick="jump_map({{ $item->map_id }}, {{ $item->pid }})">{{ $item->map_name }}</a>@if ($index % 4 == 3) <br>@endif
                @endforeach
                <a href="javascript:void(0);" class="o-bt" onclick="history.back();">返回</a>
            @endif
            <hr>
            <a href="javascript:void(0);" class="o-bt" onclick="jump_role_state()">状态</a>
            <a href="javascript:void(0);" class="o-bt" onclick="jump_role_equip()">装备</a>
            <a href="javascript:void(0);" class="o-bt" onclick="jump_role_item()">物品</a>
            <a href="javascript:void(0);" class="o-bt" onclick="jump_chat()">聊天</a>
        </div>
    </div>
</div>
<div class="layui-card">
    <div class="layui-card-body">
        <p class="now-time"><b>小Q报时({{ $now_time }})</b></p>
    </div>
</div>
</div>
</body>
</html>
<script src="{{ asset('layui/layui.js') }}"></script>
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    function jump_map(map_id, pid) {
        window.location.href = "/index?map_id=" + map_id + "&pid=" + pid
    }

    function jump_target_info(map_id, id) {
        window.location.href = "/target_info?map_id=" + map_id + "&id=" + id
    }

    function jump_duihua_info(map_id, id, pid) {
        window.location.href = "/target_info?map_id=" + map_id + "&id=" + id + "&pid=" + pid
    }

    function jump_role_state() {
        window.location.href = "/role_state"
    }

    function jump_role_equip() {
        window.location.href = "/role_equip"
    }

    function jump_role_item() {
        window.location.href = "/role_item"
    }

    function jump_target_state(id) {
        window.location.href = "/target_state?id=" + id
    }

    function jump_read(item_id, type) {
        window.location.href = "/item_info?item_id=" + item_id + "&type=" + type
    }

    function jump_chat() {
        window.location.href = "/chat"
    }

    function return_map(pid) {
        $.ajax({
            url: '/return_map',
            type: 'POST',
            contentType: 'application/json; charset=utf-8',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
            },
            data: JSON.stringify({pid: pid}),
            success: function (data) {
                if (data.success) {
                    window.location.href = data.url
                }
            }
        })
    }
</script>
