<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '添加用户' ?>
    </p>
    <div class = "content">
        <div class = "user-add">
            <form class="layui-form" action = "<?php echo site_url() . '/admin/user/add_do' ?>" method = "POST">
                <table class="layui-table fixed-table">
                    <tr>
                        <td>
                            <label for="username">请输入账号名(由数字或者字母组成)：</label>
                        </td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="username" maxlength = "20" value = "<?php echo set_value('username'); ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('username'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nickname">请输入用户昵称：</label>
                        </td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="nickname" maxlength = "20" value="<?php echo set_value('nickname'); ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('nickname'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">请输入用户密码：</label>
                        </td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="password" maxlength = "20" value="123456">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('password'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="privilege">请选择用户权限：</label>
                        </td>
                        <td>
                            <?php
                            if (!$privilege) {
                                echo '必须先添加一个权限！';
                            } else {
                                foreach ($privilege as $key => $value) {
                                    if ($value->privilege_code === 'admin') {
                                        continue;
                                    }

                                    if (!$key) {
                                        echo "<input class = 'privilege-checkbox' type = 'checkbox' checked = 'checked' name = 'privilege[]' value = '{$value->privilege_code}' title = '{$value->privilege_name}' />";
                                    } else {
                                        echo "<input class = 'privilege-checkbox' type = 'checkbox' name = 'privilege[]' value = '{$value->privilege_code}' title = '{$value->privilege_name}' />";
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('privilege[]'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="warehouse">请为用户指定一个仓库：</label>
                        </td>
                        <td>
                            <select name = 'warehouse' lay-search>
                                <option value = ''>请选择</option>
                                <?php
                                foreach ($warehouse as $key => $value) {
                                    echo "<option value = '{$value['wid']}'" . set_select('warehouse', $value['wid']) . ">{$value['warehouse_name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('warehouse'); ?></span>
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

