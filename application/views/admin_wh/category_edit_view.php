<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '编辑分类' ?>
    </p>
    <div class = "content">
        <div class = "category-edit">
        <?php
            $current_cate = $result['current_cate'][0];
            $category = $result['category'];
        ?>
            <form class="layui-form" action = "<?php echo site_url() . '/admin_wh/category/edit_do/' . $current_cate['cid']; ?>" method = "POST">
                <input type="hidden" name="form_token" value = "<?php echo $this->session->form_token = md5(mt_rand() . time()); ?>">
                <table class = "layui-table fixed-table">
                    <tr>
                        <td>
                            <label for="parent-category">请选择上级分类:</label>
                        </td>
                        <td>
                            <select name = 'parent-category' lay-search>
                                <option value = "">请选择</option>
                                <?php
                                foreach ($category as $key => $value) {
                                    if ($current_cate['cid'] === $value['cid']) {
                                        continue;
                                    }
                                    if ($current_cate['pid'] === $value['cid']) {
                                        echo '<option selected = \'selected\' value = "' . $value['cid'] . '">' . $value['category_name'] . '</option>';
                                    } else {
                                        echo '<option value = "' . $value['cid'] . '">' . $value['category_name'] . '</option>';
                                    }
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
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="category-name" maxlength = "20" value = "<?php echo $current_cate['category_name']; ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('category-name'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class = "save-btn layui-btn" type="submit" name="save-btn" value="保存">
                            <input class = "cancel-btn layui-btn" type="button" onclick = "window.location.href = '../list'" value="取消">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
