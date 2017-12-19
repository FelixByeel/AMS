<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : '资产管理系统'; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href= "<?php echo base_url() . 'public/css/common.css?v=1.01'; ?>" rel="stylesheet">
        <link href= "<?php echo base_url() . 'public/css/admin_wh_view.css?v=1.0'; ?>" rel="stylesheet">
        <link href= "<?php echo base_url() . 'public/layui/css/layui.css'; ?>" rel="stylesheet">
        <script type = "text/javascript" src = "<?php echo base_url() . 'public/layui/layui.js'; ?>"></script>
        <script type = "text/javascript" src = "<?php echo base_url() . 'public/js/jquery-1.8.3/jquery.min.js'; ?>"></script>

        <script type = "text/javascript" src = "<?php echo base_url() . 'public/js/echarts.js'; ?>"></script>
    </head>
    <!-- 仓库管理员 -->
    <body class = "current-nav-<?php echo $current_page_class; ?>">
        <div class = "nav-wrapper">
            <div class = "logo">资产管理系统</div>

            <ul class = "nav-home nav-list mt-20">
                <li class = "nav menu"><a class = "nav-home-page" href="<?php echo site_url() . '/admin_wh/home'; ?>">首页</a></li>
            </ul>

            <ul class = "nav-goods nav-list">
                <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-goods-list" href="<?php echo site_url() . '/admin_wh/goods/list'; ?>">物品管理</a></li>
            </ul>

            <ul class = "nav-cate nav-list ">
                <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-cate-list" href="<?php echo site_url() . '/admin_wh/category/list'; ?>">分类管理</a></li>
            </ul>

            <ul class = "nav-box nav-list">
                <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-box-list" href="<?php echo site_url() . '/admin_wh/box/list'; ?>">储物柜管理</a></li>
            </ul>

            <ul class = "nav-supplier nav-list">
                <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-supplier-list" href="<?php echo site_url() . '/admin_wh/supplier/list'; ?>">供货商管理</a></li>
            </ul>

            <ul class = "nav-computer nav-list">
                <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-computer-list" href="<?php echo site_url() . '/admin_wh/computer/list'; ?>">电脑型号管理</a></li>
            </ul>

            <ul class = "nav-record nav-list">
                <hr class="layui-bg-cyan">
                <li class = "nav menu"><a class = "nav-record-in" href="<?php echo site_url() . '/admin_wh/record/record_in'; ?>">入库记录</a></li>
                <li class = "nav menu"><a class = "nav-record-check" href="<?php echo site_url() . '/admin_wh/record/record_check'; ?>">盘点记录</a></li>
            </ul>

            <p class = "footer">&copy;<?php echo date('Y');?>.</p>
        </div>

        <div class = "header">
            <div id = "profileBox" class = "profile-box">
                <div class="head-icon fl-lt">
                    <img src="<?php echo base_url() . 'public/images/head/default.png'; ?>"/>
                </div>
                <span class = "user-nick-name">
                    <?php
                        echo '<span class = \'header-name\'>' . $this->session->user_nickname . '</span>';
                        echo '--<span class = \'header-wh\'>' . $this->session->user_warehouse_name . '</span>';
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
