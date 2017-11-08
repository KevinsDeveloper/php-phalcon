<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title>Login-Admin</title>

    <meta name="description" content="login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">

    <!--Basic Styles-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="/assets/css/beyond.min.css" rel="stylesheet" />
    <link href="/assets/css/animate.min.css" rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <script src="/assets/js/jquery-2.0.3.min.js"></script>
    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="/assets/js/skins.min.js"></script>
</head>
<!--Head Ends-->
<!--Body-->
<body>
    <form id="loginForm" action="{{ this.url.get('/login/do') }}" method="post" class="form-horizontal">
    <input type="hidden" name="redirect" value="{{ redirect }}">
    <div class="login-container animated fadeInDown">
        <div class="loginbox bg-white">
            <div class="loginbox-title">门道管理中心</div>
            <div class="loginbox-or marbot-15">
                <div class="or-line"></div>
                <div class="or">login</div>
            </div>
            <div class="loginbox-textbox form-group">
                <input type="text" class="form-control" placeholder="账号" name="account" minlength="5" required/>
            </div>
            <div class="loginbox-textbox form-group">
                <input type="password" class="form-control" placeholder="密码" name="password" minlength="6" required/>
            </div>
            <div class="loginbox-textbox form-group">
                <div class="col-lg-5" style="padding-left:0">
                    <input type="text" class="form-control" placeholder="验证码" id="captcha" name="captcha" required/>
                </div>
                <div class="col-lg-7">
                    <img class="captcha" src="{{this.url.get('/login/captcha')}}" onclick="this.src='/login/captcha?t=' + Math.random();" title="看不清楚？点击切换">
                </div>
            </div>
            <div class="loginbox-forgot">
                <a href="javascript:;" onclick="layer.msg('请联系管理员！', {icon: 5})">Forgot Password?</a>
            </div>
            <div class="loginbox-submit form-group padtop-20">
                <input type="submit" class="btn btn-primary btn-block" value="Login">
            </div>
        </div>
    </div>
    </form>
    {% include 'layouts/bot.volt' %}
    <script>
        var _captcha = $('.captcha'), _captchaInput = $('#captcha');
        var errorClear = function () {
            _captcha.click();
            _captchaInput.val('');
        };
        // 执行登录
        $('#loginForm').validate({
            errorPlacement: function (error, element) {
                layer.tips(error[0].textContent, element, {tipsMore: true, time: 1000});
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    dataType: "json",
                    success: function (res) {
                        if (!res || res == '') {
                            errorClear();
                            return layer.msg('Post Request Exception', {icon: 5});
                        }
                        if (res.ret != 200) {
                            errorClear();
                            return layer.msg(res.msg, {icon: 5});
                        }
                        if (res.data.redirect) {
                            location.href = res.data.redirect;
                        }
                        else
                        {
                            location.href = '/';
                        }
                    },
                    error: function (res) {
                        errorClear();
                        return layer.msg(res.responseJSON.msg, {icon: 5});
                    }
                });
            }
        });
    </script>
    <!--[if lt IE 8]>
    <script src="/assets/js/up.js"></script>
    <![endif]-->
</body>
<!--Body Ends-->
</html>
