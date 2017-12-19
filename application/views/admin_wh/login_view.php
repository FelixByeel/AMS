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
        background-color: #FFF;
    }

    .login-box {
        margin:auto;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 600px;
        height: 300px;
        box-shadow: 0 1px 7px 2px #000;
        border-radius: 5px;
        background-color: #555;
    }

    .title {
        float: left;
        padding-left: 5px;
        width: 600px;
        height: 35px;
        line-height: 35px;
        box-sizing: border-box;
        border-bottom: 1px solid #000;
        border-radius: 5px 5px 0 0;
        font-size: 2em;
        color: #FFF;
        background-color: #D66853;
    }

    .box {
        margin:auto;
        position: absolute;
        top: -20px;
        right: 0;
        bottom: 0;
        left: 0;
        width: 250px;
        height: 150px;
    }

    .user-input {
        width: 250px;
        height: 30px;
        line-height: 30px;
        background-color: #333;
        color: #fff;
        border: 1px solid #777;
        border-radius: 3px;
    }

    label {
        padding: 1px 0;
        height: 20px;
        line-height: 20px;
        color: #ccc;
    }

    .checkbox {
        vertical-align: middle;
    }

    button {
        float: right;
        width: 80px;
        height: 30px;
        border: none;
        border-radius: 3px;
        background-color: #D66853;
        color: #FFF;
        box-shadow: 0 0 2px 1px #333;
        cursor: pointer;
    }

    button:active {
        position: relative;
        top: 1px;
    }

    .login-msg{
        display: block;
        color:red;
        width: 250px;
        height:25px;
        line-height: 25px;
        text-align: center;
        font-size: 16px;
    }

    .admin {
        font-size: 16px;
        color: #FFF;
    }

    p.user-login {
        margin-top:20px;
        padding-top:25px;
        text-align:right;
    }

    p.user-login a:link {color: #F24236}
    p.user-login a:visited {color: #F24236}
    p.user-login a:hover {color: #DDD}
</style>
<script>
/**
 * Admin login
 */

 function admin_login() {

    let username = $("#username").val();
    let password = $("#userpwd").val();

    if (username == "" || password == "") {
        $("#login_msg").html('用户名或密码不能为空！');
        return false;
    } else {
        $("#login_msg").html("");
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
<div class = "login-box">
    <span class = "title">资产管理系统-<span class = "admin">管理员</span></span>

    <div class = "box">
        <span id = "login_msg" class = "login-msg"></span>
        <input class = "user-input" id = "username" name="username" type = "text" maxlength = "15" placeholder="用户名" value=""/>
        <br/>
        <br/>
        <br/>
        <input class = "user-input" id = "userpwd" name= "userpwd" type = "password" maxlength = "15" placeholder="密码" value=""/>
        <br/>
        <br/>
        <br/>
        <button id = "admin_login_btn">登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录</button>

        <p class = "user-login">
            <a href="<?php echo site_url(); ?>">普通用户登录</a>
        </p>
    </div>
</div>
</body>
</html>
