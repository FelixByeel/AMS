<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '物品出库' ?>
    </p>
    <div class = "content">
        <div class = "goods-checkout">
            <form class="layui-form" action = "<?php echo site_url() . '/index/goods/checkout_do/' . $result['goods'][0]['gid'] . (empty($page) ? '' : '/' . $page); ?>" method = "POST">
                <input type="hidden" name="form_token" value = "<?php echo $this->session->form_token = md5(mt_rand() . time()); ?>">
                <table class = "layui-table fixed-table">
                    <tr>
                        <td>物品名称：</td>
                        <td>
                            <input type="hidden" name = "goods-id" value = "<?php echo $result['goods'][0]['gid']; ?>">

                            <?php
                                echo $result['goods'][0]['goods_name'];
                            ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr style = "display:none">
                        <td>供应商名称：</td>
                        <td>
                        <?php
                            echo $result['goods'][0]['supplier_name'];
                        ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>物品序列号（SN）：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" type="text" name="goods-sn" value="<?php echo set_value('goods-sn'); ?>" maxlength = '20'>
                        </td>
                        <td>
                            <span class = "error-msg"><?php echo form_error('goods-sn'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>工号：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="consumer-code" value="<?php echo set_value('consumer-code'); ?>" maxlength = '20'>
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('consumer-code'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>电脑型号：</td>
                        <td>
                            <select name = 'computer-type' lay-search>
                                <option value="">请选择</option>
                                <?php
                                $html = '';
                                foreach ($result['computer_type'] as $key => $value) {
                                    $html .= '<option value = "' . $value['typeid'] . '"' . set_select('computer-type', $value['typeid']) . '>' . $value['type_name'] . '</option>';
                                }
                                echo $html;
                                ?>
                            </select>
                        </td>
                        <td>
                            <span class = "error-msg"><?php echo form_error('computer-type'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>电脑序列号（SN）：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" type="text" name="computer-sn" value="<?php echo set_value('computer-sn'); ?>" maxlength = '20'>
                        </td>
                        <td>
                            <span class = "error-msg"><?php echo form_error('computer-sn'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>电脑资产条码：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" id = "computer_barcode" type="text" name="computer-barcode" value="<?php echo set_value('computer-barcode'); ?>" maxlength = '12'>
                        </td>
                        <td>
                            <span class = "error-msg"><?php echo form_error('computer-barcode'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>库存数量：</td>
                        <td>
                            <?php echo $result['goods'][0]['goods_count']; ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>出库数量：</td>
                        <td>
                            <input autocomplete="off" class="layui-input" required lay-verify="required" type="text" name="checkout-count" value="1" maxlength = '20'>
                        </td>
                        <td>
                            <span class = "error-msg">*&nbsp;&nbsp;<?php echo form_error('checkout-count'); ?></span>
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
