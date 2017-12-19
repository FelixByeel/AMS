<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '添加物品';?>
    </p>
    <div class = "content">
        <div class = "goods-add">
            <form class="layui-form" action = "<?php echo site_url() . '/admin_wh/goods/add_do' ?>" method = "POST">
                <input type="hidden" name="form_token" value = "<?php echo $this->session->form_token = md5(mt_rand() . time()); ?>">
                <table  class = "layui-table fixed-table">
                    <tr>
                        <td>请输入物品名称：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="goods-name" maxlength = "20" value = "<?php echo set_value('goods-name'); ?>">
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('goods-name'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>请选择分类：</td>
                        <td>
                            <select name = 'category' lay-search>
                                <option value="">请选择</option>
                                <?php
                                $html = '';
                                foreach ($result['category'] as $key => $value) {
                                    $html .= '<option value = "' . $value['cid'] . '"' . set_select('category', $value['cid']) . '>' . $value['category_name'] . '</option>';
                                }
                                echo $html;
                                ?>
                            </select>
                        </td>
                        <td>
                            <span><a class = 'action-link' href = "javascript:;" onclick = "go_back('<?php echo site_url('admin_wh/category/add'); ?>')">添加新分类</a></span>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('category'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>请选择存放储物柜：</td>
                        <td>
                            <select name = 'box' lay-search>
                                <option value="">请选择</option>
                                <?php
                                $html = '';
                                foreach ($result['box'] as $key => $value) {
                                    $html .= '<option value = "' . $value['bid'] . '"' . set_select('box', $value['bid']) . '>' . $value['box_name'] . '</option>';
                                }
                                echo $html;
                                ?>
                            </select>
                        </td>
                        <td>
                            <span><a class = 'action-link' href = "javascript:;" onclick = "go_back('<?php echo site_url('admin_wh/box/add'); ?>')">添加储物柜</a></span>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('box'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>请选择供应商：</td>
                        <td>
                            <select name = 'supplier' lay-search>
                                <option value="">请选择</option>
                                <?php
                                $html = '';
                                foreach ($result['supplier'] as $key => $value) {
                                    $html .= '<option value = "' . $value['sid'] . '"' . set_select('supplier', $value['sid']) . '>' . $value['supplier_name'] . '</option>';
                                }
                                echo $html;
                                ?>
                            </select>
                        </td>
                        <td>
                            <span><a class = 'action-link' href = "javascript:;" onclick = "go_back('<?php echo site_url('admin_wh/supplier/add'); ?>')">添加供应商</a></span>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('supplier'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>请输入物品数量：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" type="text" name="goods-count" maxlength = "20" value = "<?php echo set_value('goods-count'); ?>">
                        </td>
                        <td>
                            <span class = "error-msg"><?php echo form_error('goods-count'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class = "add-btn layui-btn" type="submit" name="add-btn" value="添加">
                            <input class = "cancel-btn layui-btn" type="button" onclick = "window.location.href = './list'" value="取消">
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
