<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '入库记录' ?>
    </p>
    <div class = "content">
        <table class = "layui-table fixed-table">
            <thead>
                <tr class = "tr-head">
                    <th>物品名称</th>
                    <th>供应商</th>
                    <th>入库数量</th>
                    <th>入库日期</th>
                    <th>处理人</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($result as $key => $value) {
                $html = '<tr>';
                $html .= '<td>' . $value['goods_name'] . '</td>';
                $html .= '<td>' . $value['supplier_name'] . '</td>';
                $html .= '<td>' . $value['in_count'] . '</td>';
                $html .= '<td>' . date('Y-m-d', $value['record_time']) . '</td>';
                $html .= '<td>' . $value['nick_name'] . '</td>';
                $html .='</tr>';

                echo $html;
            }
            ?>
            </tbody>
        </table>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
