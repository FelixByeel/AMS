<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '编辑用户' ?>
    </p>
    <div class = "content">
        <div class = "user-add">
            <form class="layui-form" action = "<?php echo site_url() . '/admin/user/edit_do/' . $result[0]->uid . (empty($page) ? '' : '/' . $page); ?>" method = "POST">
                <table class="layui-table fixed-table">
                    <tr>
                        <td>
                            <label for="username">账号名：</label>
                        </td>
                        <td>
                            <label><?php echo $result[0]->username; ?></label>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nickname">用户昵称：</label>
                        </td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="nickname" maxlength = "20" value="<?php echo $result[0]->nick_name; ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('nickname'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="privilege">请选择用户权限：</label>
                        </td>
                        <td>
                            <?php
                            if (!$privilege) {
                                echo '权限异常！看到这条信息请联系管理员处理。';
                            } else {
                                $user_privilege = explode('-', $result[0]->privilege_code);

                                foreach ($privilege as $key => $value) {
                                    if ($value->privilege_code === 'admin') {
                                        continue;
                                    }

                                    if (in_array($value->privilege_code, $user_privilege)) {
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
                                    if ($result[0]->wid === $value['wid']) {
                                        echo "<option selected = 'selected' value = '{$value['wid']}'>{$value['warehouse_name']}</option>";
                                    } else {
                                        echo "<option value = '{$value['wid']}'>{$value['warehouse_name']}</option>";
                                    }
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
                            <input class = "save-btn layui-btn btn" type="submit" name="save-btn" value="保存">
                            <input class = "cancel-btn layui-btn btn" type="button" onclick = "window.location.href = '<?php echo empty($page) ? '../list' : '../../list/' . $page; ?>'" value="取消">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

