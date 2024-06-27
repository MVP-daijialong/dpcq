<!-- 页头部分 -->
@include('layouts.header')
<body>
<div class="container">
    <div class="layui-card">
        <div class="layui-card-header">聊天区</div>
        <div class="layui-card-body">
            <div class="layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">聊天记录</h2>
                    <div class="layui-colla-content layui-show" id="chat-history">
                        <!-- 聊天记录显示区域 -->
                        @foreach($msg_arr as $v)
                            <p>{{ $v['msg'] }}</p>
                        @endforeach
                    </div>
                </div>
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

                <p>
                    <a href="javascript:void(0);" onclick="window.location.href='{{ $history_url }}'">返回游戏</a>
                </p>
            </div>
        </div>
    </div>
    @include('layouts.footer')
    <script>
        layui.use(['form'], function(){
            var form = layui.form;
            var socket = new WebSocket('ws://localhost:6001');

            socket.onopen = function() {
                console.log('WebSocket connection opened');
                startHeartbeat();
            };

            socket.onmessage = function(event) {
                console.log('Received message: ' + event.data);
                appendMessageToChatHistory(event.data);
            };

            socket.onclose = function() {
                console.log('WebSocket connection closed');
                reconnect();
            };

            socket.onerror = function(error) {
                console.log('WebSocket error: ' + error.message);
                reconnect();
            };

            form.on('submit(send)', function(data){
                var role_id = '{{ $role->role_id }}';
                var role_name = '{{ $role->role_name }}';
                var server_id = '{{ $role->server_id }}';
                var chat_channel = 1; // 假设是世界聊天
                var message = data.field.message;

                var dataToSend = JSON.stringify({
                    role_id: role_id,
                    role_name: role_name,
                    server_id: server_id,
                    chat_channel: chat_channel,
                    message: message
                });

                socket.send(dataToSend);
                document.getElementById('message-input').value = '';
                return false; // 阻止表单提交
            });

            function appendMessageToChatHistory(message) {
                var chatHistory = document.getElementById('chat-history');
                var p = document.createElement('p');
                p.textContent = message;
                chatHistory.appendChild(p);
            }

            function startHeartbeat() {
                setInterval(function() {
                    if (socket.readyState === WebSocket.OPEN) {
                        socket.send(JSON.stringify({type: 'heartbeat'}));
                    }
                }, 1000); // 每秒发送一次心跳
            }

            function reconnect() {
                layer.msg("服务器重连中...")
                setTimeout(function() {
                    location.reload();
                }, 2000); // 5秒后刷新页面重新连接
            }
        });
    </script>
</body>
</html>
