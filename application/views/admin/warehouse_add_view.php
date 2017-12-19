<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '添加仓库' ?>
    </p>
    <div class = "content">
        <div class = "wh-add">
            <form class="layui-form" action = "<?php echo site_url() . '/admin/warehouse/add_do' ?>" method = "POST">
                <input type="hidden" name="form_token" value = "<?php echo $this->session->form_token = md5(mt_rand() . time()); ?>">
                <table class="layui-table fixed-table">
                    <tr>
                        <td>请输入仓库名称：</td>
                        <td>
                        <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="wh-name" maxlength = "20" value = "<?php echo set_value('wh-name'); ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('wh-name'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input class = "add-btn layui-btn" type="submit" name="add-btn" value="添加">
                            <input class = "cancel-btn layui-btn" type="button" onclick = "window.history.go(-1)" value="取消">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
