<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href= "<?php echo base_url() . 'public/css/common.css?v=1.01'; ?>" rel="stylesheet">
        <link href= "<?php echo base_url() . 'public/layui/css/layui.css'; ?>" rel="stylesheet">
        <script type = "text/javascript" src = "<?php echo base_url() . 'public/layui/layui.js'; ?>"></script>
        <script type = "text/javascript" src = "<?php echo base_url() . 'public/js/jquery-1.8.3/jquery.min.js'; ?>"></script>

    </head>
    <!-- 超级管理员 -->
    <body class = "current-nav-<?php echo isset($current_page_class) ? $current_page_class : 'home'; ?>">
        <div class = "nav-wrapper">
            <div class = "logo">资产管理系统</div>

            <ul class = "nav-home nav-list mt-20">
                <li class = "nav menu"><a class = "nav-home-page" href="<?php echo site_url() . '/admin/home'; ?>">首页</a></li>
            </ul>

            <ul class = "nav-wh nav-list">
            <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-wh-list" href="<?php echo site_url() . '/admin/warehouse/list'; ?>">仓库列表</a></li>
                <li class = "nav menu"><a class = "nav-wh-add" href="<?php echo site_url() . '/admin/warehouse/add'; ?>">添加仓库</a></li>
            </ul>

            <ul class = "nav-privilege nav-list">
            <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-privilege-list" href="<?php echo site_url() . '/admin/privilege'; ?>">权限列表</a></li>
            </ul>

            <ul class = "nav-user nav-list">
            <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-user-list" href="<?php echo site_url() . '/admin/user/list'; ?>">用户列表</a></li>
                <li class = "nav menu"><a class = "nav-user-add" href="<?php echo site_url() . '/admin/user/add'; ?>">添加用户</a></li>
            </ul>
            <p class = "footer">&copy;<?php echo date('Y'); ?>.</p>
        </div>
        <div class = "header">
                <div class = "current-position">

                </div>
            <div id = "profileBox" class = "profile-box">

                <div class="head-icon fl-lt">
                    <img src="<?php echo base_url() . 'public/images/head/default.png'; ?>"/>
                </div>
                <span class = "user-nick-name">
                    <?php
                        echo '<span class = \'header-name\'>' . $this->session->user_nickname . '</span>';
                        echo (null !== $this->session->user_warehouse_name) ? ('--<span class = \'header-wh\'>' . $this->session->user_warehouse_name . '</span>') : '';
                    ?>
                </span>

                <ul class = "profile-more-box">
                    <li class = "modify-pwd">
                    <a href="javascript:;" onclick = "go_back('<?php echo site_url('account/password'); ?>')">修改密码</a>
                    </li>
                    <li class = "logout">
                        <a href="<?php echo site_url() . '/logout'; ?>">注销登录</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class = "container">
