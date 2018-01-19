<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<!Doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<title>登录-管理员</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/public/layui/css/layui.css'); ?>">
<script src="<?php echo base_url('/public/layui/layui.js'); ?>"></script>
<script src = "<?php echo base_url() . 'public/js/jquery-1.8.3/jquery.min.js' ?>"></script>
<script src = "<?php echo base_url() . 'public/js/cookie.js'; ?>"></script>
<script src = "<?php echo base_url() . 'public/js/login.js'; ?>"></script>
<style type = "text/css">
    * {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif, "Microsoft YaHei";
        font-size: 14px;
    }

    body {
        background-color: #EFEFEF;
    }

    .login-box {
        width:400px;
        margin:auto;
        margin-top: 8%;
        padding: 20px;
        border: solid 1px #DDD;
        box-shadow: 1px 1px 5px 2px #d2d2d2;
        background-color: #FFF;
    }

    .title {
        margin-bottom:10px;
        height: 35px;
        line-height: 35px;
        box-sizing: border-box;
        border-bottom: 1px solid #000;
        border-radius: 5px 5px 0 0;
        font-size: 2em;
        color:#343434;
    }



    .checkbox {
        vertical-align: middle;
    }


    .login-msg{
        color:red;
        height:30px;
        line-height: 30px;
    }

    p.user-login {
        text-align:right;
    }

    p.user-login a:link {color: rgb(71, 171, 196)}
    p.user-login a:visited {color: rgb(71, 171, 196)}
    p.user-login a:hover {color: #333}
</style>
<script>
/** 去除前后空格 */
function trim(s){
    return s.replace(/(^\s*)|(\s*$)/g, "");
}

/**
 * Admin login
 */

 function admin_login() {

    let username = trim($("#username").val());
    let password = $("#userpwd").val();

    if (username == "" || password == "") {
        $("#login_msg").html('用户名或密码不能为空！');
        return false;
    }

    let data = {
        "username": username,
        "password": password
    }

    $.post(
        './login/do',
        { 'data': data },
        function (msg) {
            if (msg.status === 'success') {
                location.href = msg.url;
            } else {
                $("#login_msg").html(msg.status);
            }
        },
        'json'
    );
}

//响应Enter按键登录
document.onkeydown = function (event) {
    var e = event || window.event || arguments.callee.caller.arguments[0];
    if (e && e.keyCode == 13) {
        admin_login();
    }
}


/**
 *  login
 */
$(document).ready(function () {
    $("#admin_login_btn").click(function () {
        admin_login();
    });
});

</script>
</head>
<body>
<div class="login-box">
    <p class = "title">资产管理系统-<span class = "admin">管理员</span></p>
    <form action="javascript:void(0);" method="post">
        <div class="layui-form-item">
            <div id="login_msg" class="login-msg"></div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-inline" style="width:400px;">
                <input type="text" id="username" name="username" required  lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-inline" style="width:400px;">
                <input type="password" id = "userpwd" name= "userpwd" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-inline" style="width:400px;">
                <button class="layui-btn" id = "admin_login_btn" style="float:right;" >登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
            </div>
        </div>

        <div class="layui-form-item">
            <p class = "user-login">
                <a href="<?php echo site_url(); ?>">普通用户登录</a>
            </p>
        </div>
    </form>

</div>
</body>
</html>
