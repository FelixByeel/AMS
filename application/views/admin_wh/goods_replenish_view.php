<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '物品入库' ?>
    </p>
    <div class = "content">
        <div class = "goods-replenish">
            <form class="layui-form" action = "<?php echo site_url() . '/admin_wh/goods/replenish_do/' . $result[0]['gid'] . (empty($page) ? '' : '/' . $page); ?>" method = "POST">
                <input type="hidden" name="form_token" value = "<?php echo $this->session->form_token = md5(mt_rand() . time()); ?>">
                    <table  class = "layui-table fixed-table">
                        <tr>
                            <td>物品名称：</td>
                            <td><?php echo $result[0]['goods_name'] ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>当前数量：</td>
                            <td><?php echo $result[0]['goods_count'] ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>入库数量：</td>
                            <td><input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name = "goods-in-count" maxlength = "10"></td>
                            <td>
                                <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('goods-in-count'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input class = "save-btn layui-btn" type="submit" name="save-btn" value="保存">
                                <input class = "cancel-btn layui-btn" type="button" onclick = "window.location.href = '<?php echo empty($page) ? '../list' : '../../list/' . $page; ?>'" value="取消">
                            </td>
                            <td></td>
                        </tr>
                    </table>
            </form>
        </div>
    </div>
</div>
