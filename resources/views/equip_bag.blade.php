<!-- 页头部分 -->
@include('layouts.header')
<style>
    .room-actions {
        max-height: 400px; /* 限制高度 */
        overflow-y: auto; /* 显示垂直滚动条 */
        padding: 10px;
        border: 1px solid #ddd;
    }
    .room-actions p {
        margin: 5px 0;
    }
</style>
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header"><a href="javascript:void(0);" onclick="location.reload();" class="o-bt">刷新</a> <a href="javascript:void(0);" class="o-bt">任务</a></div>
        <div class="layui-card-body">
            <div class="room-description">
                装备背包：
            </div>
            <form method="GET" action="{{ url()->current() }}" class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input type="text" name="search" placeholder="搜索" autocomplete="off" class="layui-input" value="{{ $search }}">
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn" type="submit">搜索</button>
                    </div>
                </div>
            </form>
            <div class="room-actions">
                @foreach($bag_list as $v)
                    <p> [{{ $v->e_position_name }}]<a href="javascript:void(0);" style="color: {{ $v->color }}" onclick="jump_read({{ $v->item_id }}, 1)">{{ $v->item_name }}</a> | <a href="javascript:void(0);" class="o-bt" onclick="wear({{ $v->id }}, {{ $v->item_id }}, {{ $v->e_position }})">穿戴</a> <a href="javascript:void(0);" class="o-bt" onclick="sell({{ $v->id }}, {{ $v->item_id }} , '{{ $v->item_name }}', 1)">出售</a> <a href="javascript:void(0);" class="o-bt" onclick="sell({{ $v->id }}, {{ $v->item_id }}, '{{ $v->item_name }}', 0)">丢弃</a></p>
                @endforeach
            </div>
            <!-- 分页链接 -->
            <div id="pagination"></div>

            <p>
                <a href="{{ $history_url }}" class="o-bt">返回游戏</a>
            </p>
        </div>
    </div>
    <!-- 页尾部分 -->
    @include('layouts.footer')
    <script>
        layui.use(['laypage'], function(){
            var laypage = layui.laypage;

            //执行一个laypage实例
            laypage.render({
                elem: 'pagination', //注意，这里的 pagination 是 ID，不用加 # 号
                count: {{ $bag_list->total() }}, //数据总数，从服务端得到
                limit: {{ $bag_list->perPage() }}, // 每页显示的条数
                curr: {{ $bag_list->currentPage() }}, //当前页码
                jump: function(obj, first){
                    //obj包含了当前分页的所有参数，比如：
                    console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。

                    //首次不执行
                    if(!first){
                        var search = '{{ $search }}';
                        window.location.href = "?page=" + obj.curr + "&search=" + search;
                    }
                }
            });

        });

        function wear(id, item_id, e_position) {
            $.ajax({
                url: '/wear',
                type: 'POST',
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
                },
                data: JSON.stringify({id: id, item_id: item_id, e_position: e_position}),
                success: function (data) {
                    if (data.success) {
                        layer.msg(data.msg)
                        setTimeout(function() {
                            window.location.reload()
                        }, 500); // 延迟1秒 (1000毫秒)
                    } else {
                        layer.msg(data.msg)
                    }
                }
            })
        }

        function sell(id, item_id, item_name, type) {
            let text = type === 1 ? '出售[' : '丢弃['
            layer.confirm('确定要'+ text + item_name +']吗？', {
                icon: 3,
                title: '确认',
            }, function(index){
                layer.close(index); // 关闭确认框
                // 用户确认后执行的回调函数
                $.ajax({
                    url: '/sell',
                    type: 'POST',
                    contentType: 'application/json; charset=utf-8',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
                    },
                    data: JSON.stringify({id: id, item_id: item_id, type: type, sell_type: 1}),
                    success: function (data) {
                        if (data.success) {
                            layer.msg(data.msg)
                            setTimeout(function() {
                                window.location.reload()
                            }, 500); // 延迟1秒 (1000毫秒)
                        } else {
                            layer.msg(data.msg)
                        }
                    }
                })
            });
        }
    </script>
