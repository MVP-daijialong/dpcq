<!-- 页头部分 -->
@include('layouts.header')
<style>
    .t-level {
        vertical-align: bottom;
    }
</style>
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
                <span class="t-level">Lv{{ $attribute_info->t_level }}</span>
            </div>
            <div class="room-actions">
                <p><a href="javascript:void(0);" class="o-bt auto-attack-btn">开启自动攻击</a></p>
                <p>你向{{ $target_info->target_name }}发起了攻击</p>
                <p class="t-op">
                    <a href="javascript:void(0);" class="o-bt attack-btn">攻击</a>
                    <a href="javascript:void(0);" class="o-bt" onclick="jump_target_state({{ $target_info->id }})">查看</a>
                    <a href="javascript:void(0);" class="o-bt retreat">撤退({{ $target_info->retreat_amount }}金币)</a>
                </p>
            </div>
            <div class="room-actions">
                <p>{{ $target_info->target_name }}生命值: (<span class="t-now-hp">{{ $attribute_info->t_hp }}</span>/<span class="t-all-hp">{{ $attribute_info->t_hp }}</span>)</p>
                <p>{{ $roles_info->role_name }}生命值: (<span class="m-now-hp">{{ $roles_info->r_now_hp }}</span>/<span class="m-all-hp">{{ $roles_info->r_hp }}</span>)</p>
            </div>
            <div id="battle-report" class="room-actions">

            </div>
        </div>
    </div>
    <!-- 页尾部分 -->
    @include('layouts.footer')
    <script>
        $(document).ready(function() {
            let currentTargetHp = {{ $attribute_info->t_hp }};
            let currentRoleHp = {{ $roles_info->r_now_hp }};
            let flag = true;
            let autoAttackInterval;

            function attack(role_id, target_id) {
                if (!flag) {
                    return; // If the battle is already over, return immediately without executing further logic
                }

                let battleReport = $('#battle-report');

                $.ajax({
                    url: '/attack',
                    type: 'POST',
                    contentType: 'application/json; charset=utf-8',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
                    },
                    data: JSON.stringify({ roleId: role_id, targetId: target_id }),
                    success: function(data) {
                        if (data.success) {
                            let equipment = data.equipment
                            let level_text = data.level_text
                            battleReport.empty(); // Clear previous content
                            $.each(data.battleDetails, function(index, detail) {
                                let p = $('<p></p>').html(`${detail.desc}`);
                                battleReport.append(p);

                                if (index === 0) {
                                    $('.t-now-hp').text(detail.target_now_hp);
                                    if (detail.target_now_hp === 0) {
                                        flag = false; // Mark battle as over
                                    }
                                } else {
                                    $('.m-now-hp').text(detail.role_now_hp);
                                    if (detail.role_now_hp === 0) {
                                        flag = false; // Mark battle as over
                                    }
                                }

                            });

                            // Check if battle is over after processing all details
                            if (!flag) {
                                let p = $('<p></p>').html('*战斗结束！');
                                battleReport.append(p);
                                if (equipment) {
                                    let p = $('<p></p>').html(equipment);
                                    battleReport.append(p);
                                }
                                if (level_text) {
                                    let p = $('<p></p>').html(level_text);
                                    battleReport.append(p);
                                }
                            }
                        } else {
                            alert('战斗失败：' + data.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Assuming you have a button with class "attack-btn" to trigger the attack
            $('.attack-btn').on('click', function() {
                attack({{ $roles_info->role_id }}, {{ $target_info->id }});
            });

            $('.auto-attack-btn').on('click', function() {
                if ($(this).text() === '开启自动攻击') {
                    if (currentTargetHp === 0 || currentRoleHp === 0) {
                        return false;
                    }
                    $(this).text('停止自动攻击');
                    autoAttackInterval = setInterval(function() {
                        if (!flag) {
                            $('.auto-attack-btn').text('开启自动攻击');
                            clearInterval(autoAttackInterval); // Stop the interval if the battle is over
                        } else {
                            attack({{ $roles_info->role_id }}, {{ $target_info->id }});
                        }
                    }, 1000); // Trigger every second
                } else {
                    $(this).text('开启自动攻击');
                    clearInterval(autoAttackInterval);
                }
            });
        });

        $(".retreat").on('click', function() {
            layui.use(['layer'], function(){
                var layer = layui.layer;

                // 弹出确认框
                layer.confirm('确定要撤退吗？', {
                    icon: 3,
                    title: '确认',
                }, function(index){
                    layer.close(index); // 关闭确认框
                    // 用户确认后执行的回调函数
                    $.ajax({
                        url: '/retreat',
                        type: 'POST',
                        contentType: 'application/json; charset=utf-8',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to handle CSRF in Laravel
                        },
                        data: JSON.stringify({role_id: {{ $roles_info->role_id }}, target_id: {{ $target_info->id }}}),
                        success: function (data) {
                            if (data.success) {
                                layer.msg(data.msg)
                                history.back();
                            } else {
                                layer.msg(data.msg)
                            }
                        }
                    })
                });
            });
        });

    </script>
