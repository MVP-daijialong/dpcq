@include('layouts.header')

<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md7 layui-col-md-offset3">
            <div class="layui-card">
                <div class="layui-card-header layui-text-center" style="font-size: 24px;">创建角色</div>
                <div class="layui-card-body">
                    <form method="POST" action="{{ route('create_role') }}" class="layui-form">
                        @csrf

                        <div class="layui-form-item">
                            <label for="role_name" class="layui-form-label">角色名称</label>
                            <div class="layui-input-block">
                                <input id="role_name" type="text" class="layui-input @error('role_name') layui-form-danger @enderror" name="role_name" required>
                                @error('role_name')
                                <div class="layui-form-mid layui-word-aux">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button type="button" class="layui-btn layui-btn-primary" id="random-role-name">随机名称</button>
                                <button type="submit" class="layui-btn layui-btn-normal">确定</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/layui/layui.js"></script>
<script>
    document.getElementById('random-role-name').addEventListener('click', function () {
        const characters = '风云龙虎凤天地山水火雷电光影月星云天风雷霜雪冰火雨海云川湖河江流石峰峡谷洞林草木花鸟鱼兽灵魂魔神圣鬼妖侠剑道仙佛巫神龙虎豹熊狼鹰蛇鳄狐狐貂鹤猿马驴骡骆牛羊鸡鸭猪狗猫鼠虎狮豹象狻猊麒麟獬豸玄武白虎朱雀青龙水龙神龙魔龙紫龙黑龙白龙青龙金龙火龙木龙土龙水龙火龙雷龙风龙电龙云龙光龙影龙黑龙白龙金龙银龙铜龙铁龙石龙玉龙龙';

        let roleName = '';
        const maxLength = 6;
        for (let i = 0; i < maxLength; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            roleName += characters[randomIndex];
        }

        document.getElementById('role_name').value = roleName;
    });
</script>
