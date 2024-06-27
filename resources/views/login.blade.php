@include('layouts.header')

<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md7 layui-col-md-offset3">
            <div class="layui-card">
                <div class="layui-card-header layui-text-center" style="font-size: 24px;">登录账号</div>
                <div class="layui-card-body">
                    <form method="POST" action="{{ route('login') }}" class="layui-form">
                        @csrf

                        <div class="layui-form-item">
                            <label for="name" class="layui-form-label">账号</label>
                            <div class="layui-input-block">
                                <input id="name" type="text" class="layui-input @error('name') layui-form-danger @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <div class="layui-form-mid layui-word-aux">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="password" class="layui-form-label">密码</label>
                            <div class="layui-input-block">
                                <input id="password" type="password" class="layui-input @error('password') layui-form-danger @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <div class="layui-form-mid layui-word-aux">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label for="captcha" class="layui-form-label">验证码</label>
                            <div class="layui-input-inline">
                                <input id="captcha" type="text" class="layui-input @error('captcha') layui-form-danger @enderror" name="captcha" required maxlength="4">
                            </div>
                            <div class="layui-input-inline">
                                <img src="{{ captcha_src() }}" onclick="this.src='{{ captcha_src() }}'+Math.random()" class="layui-captcha" title="点击刷新验证码" style="cursor: pointer;">
                            </div>
                            @error('captcha')
                            <div class="layui-form-mid layui-word-aux">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <p>还没有账号？去<a href="/register" style="color: #01AAED">注册</a></p>
                                <button type="submit" class="layui-btn layui-btn-normal">
                                    提交
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
