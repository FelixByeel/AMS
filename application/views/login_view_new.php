<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<!Doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<title>登录</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

<link rel="stylesheet" type="text/css" href="<?php echo base_url('/public/layui/css/layui.css'); ?>">
<script src="<?php echo base_url('/public/layui/layui.js'); ?>"></script>
<script src = "<?php echo base_url() . 'public/js/jquery-1.8.3/jquery.min.js' ?>"></script>
<script src = "<?php echo base_url() . 'public/js/cookie.js?v=1.0'; ?>"></script>
<script src = "<?php echo base_url() . 'public/js/login.js?v=1.0'; ?>"></script>
<style type = "text/css">
    * {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif, "Microsoft YaHei";
        font-size: 14px;
    }

    body {
        width:100%;
        height: 100%;
        background-color: #EFEFEF;
    }

    /* login */
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

    .admin-login {

        text-align:right;
    }

    .admin-login a:link {color: rgb(71, 171, 196)}
    .admin-login a:visited {color: rgb(71, 171, 196)}
    .admin-login a:hover {color: #333}
</style>
</head>
<body>
<div class="login-box">
    <p class = "title">资产管理系统</p>
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
            <label>
                <input class = "checkbox" id = "rememberpwd" name = "rememberpwd" type="checkbox"/>&nbsp;记住密码
            </label>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-inline" style="width:400px;">
                <button class="layui-btn" id = "login_btn" style="float:right;"  lay-filter="formDemo">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
            </div>
        </div>

        <div class="layui-form-item">
            <p class = "admin-login">
                <a href="<?php echo site_url('admin_wh/login'); ?>">管理员登录</a>
            </p>
        </div>
    </form>

</div>
</body>
</html>
