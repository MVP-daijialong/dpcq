<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header">聊天区</div>
        <div class="layui-card-body">
            <div class="layui-collapse">
                <div class="layui-tab layui-tab-brief" lay-filter="chat-tabs">
                    <ul class="layui-tab-title">
                        <li class="layui-this" lay-id="world">世界</li>
                        <li lay-id="current">当前</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show" id="chat-history-world">
                            <!-- 世界聊天记录显示区域 -->
                            @foreach($world_msg_arr as $v)
                                <p>{{ $v['msg'] }}</p>
                            @endforeach
                        </div>
                        <div class="layui-tab-item" id="chat-history-current">
                            <!-- 当前场景聊天记录显示区域 -->
                            @foreach($current_msg_arr as $v)
                                <p>{{ $v['msg'] }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="layui-collapse">
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">聊天输入</h2>
                        <div class="layui-colla-content layui-show">
                            <form class="layui-form" id="message-form" action="">
                                <div class="layui-form-item layui-form-text">
                                    <textarea class="layui-textarea" name="message" id="message-input" placeholder="请输入消息内容"></textarea>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn layui-btn-sm" lay-submit lay-filter="send">发送</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <p>
                    <a href="javascript:void(0);" onclick="window.location.href='{{ $history_url }}'">返回游戏</a>
                </p>
            </div>
        </div>
    </div>
    @include('layouts.footer')
    <script>
        layui.use(['form', 'element'], function(){
            var form = layui.form;
            var element = layui.element;
            var socket = new WebSocket('ws://localhost:6001');

            socket.onopen = function() {
                console.log('WebSocket connection opened');
                startHeartbeat();
            };

            socket.onmessage = function(event) {
                console.log('Received message: ' + event.data);
                var data = JSON.parse(event.data);
                appendMessageToChatHistory(data.message, data.chat_channel, data.map_id);
            };

            socket.onclose = function() {
                console.log('WebSocket connection closed');
                reconnect();
            };

            socket.onerror = function(error) {
                console.log('WebSocket error: ' + error.message);
                reconnect();
            };

            // 监听选项卡切换事件
            var chat_channel = 1
            element.on('tab(chat-tabs)', function(data) {
                var layId = $(this).attr('lay-id');
                chat_channel = layId === 'world' ? 1 : 2;
            });

            form.on('submit(send)', function(data){
                var role_id = '{{ $role->role_id }}';
                var role_name = '{{ $role->role_name }}';
                var server_id = '{{ $role->server_id }}';
                var map_id = '{{ $map_id }}'; // 获取当前场景的map_id
                var message = data.field.message;

                var dataToSend = JSON.stringify({
                    role_id: role_id,
                    role_name: role_name,
                    server_id: server_id,
                    map_id: map_id,
                    chat_channel: chat_channel,
                    message: message
                });

                socket.send(dataToSend);
                document.getElementById('message-input').value = '';
                return false; // 阻止表单提交
            });

            function appendMessageToChatHistory(message, chat_channel, map_id) {
                var chatHistory = chat_channel === 1 ? document.getElementById('chat-history-world') : document.getElementById('chat-history-current');
                var p = document.createElement('p');
                p.textContent = message;
                chatHistory.appendChild(p);
            }

            function startHeartbeat() {
                setInterval(function() {
                    if (socket.readyState === WebSocket.OPEN) {
                        socket.send(JSON.stringify({type: 'heartbeat'}));
                    }
                }, 1000); // 每30秒发送一次心跳
            }

            function reconnect() {
                layer.msg("服务器重连中...")
                setTimeout(function() {
                    location.reload();
                }, 2000); // 5秒后刷新页面重新连接
            }
        });
    </script>
