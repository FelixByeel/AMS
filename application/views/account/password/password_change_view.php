<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '修改密码' ?>
    </p>
    <div class = "content">
        <div class = "password-change">
            <form class="layui-form" action = "<?php echo site_url('/account/password/change?uri=' . $old_uri); ?>" method = "POST">
                <table class = "layui-table fixed-table">
                    <tr>
                        <td>请输入旧密码：</td>
                        <td>
                        <input autocomplete="off" class="layui-input" required lay-verify="required" type="password" name="old-password" maxlength = "20" value="">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('old-password'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>请输入新密码：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="password" name="new-password" maxlength = "20" value="">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('new-password'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>请确认新密码：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="password" name="confirm-password" maxlength = "20" value="">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('confirm-password'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input class = "save-btn layui-btn" type="submit" name="save-btn" value="保存">
                            <input class = "cancel-btn layui-btn" type="button" onclick = "window.location.href='<?php echo $old_uri; ?>'" value="取消">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
