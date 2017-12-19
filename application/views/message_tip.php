<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>

<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '提示消息'; ?>
    </p>
    <div class = "content">
        <div class = "msg">
            <?php
                echo !isset($msg) ? '请勿刷新页面重复提交表单！' : $msg;
            ?>
        </div>
    </div>
</div>
