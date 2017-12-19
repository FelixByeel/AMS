<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>

<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '添加分类'; ?>
    </p>
    <div class = "content">
        <div class = "category-add">
            <form class="layui-form" action = "<?php echo site_url() . '/admin_wh/category/add_do' . (empty($old_uri) ? '' : '?uri=' . $old_uri); ?>" method = "POST">
                <input type="hidden" name="form_token" value = "<?php echo $this->session->form_token = md5(mt_rand() . time()); ?>">
                <table class = "layui-table fixed-table">
                    <tr>
                        <td>
                            <label for="parent-category">请选择上级分类:</label>
                        </td>
                        <td>
                            <select name = 'parent-category' lay-search>
                                <option value="">请选择</option>
                                <?php
                                foreach ($result as $key => $value) {
                                    echo '<option value = "' . $value['cid'] . '"' . set_select('parent-category', $value['cid']) . '>' . $value['category_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <span class = "error-msg"><?php echo form_error('parent-category'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="category-name">请输入分类名称:</label>
                        </td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="category-name" maxlength = "20" value = "<?php echo set_value('category-name'); ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('category-name'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class = "add-btn layui-btn" type="submit" name="add-btn" value="添加">
                            <input class = "cancel-btn layui-btn" type="button" onclick = "window.location.href = '<?php echo empty($old_uri) ? './list' : $old_uri; ?>'" value="取消">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
