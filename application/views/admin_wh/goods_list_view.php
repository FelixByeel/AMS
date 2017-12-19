<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '物品列表' ?>
    </p>
    <div class = "content">
        <div class = "action-header">
            <span class = "link-header">
                <a class = "action-link" href="<?php echo site_url() . '/admin_wh/goods/add'; ?>">添加物品</a>
            </span>
        </div>
        <div class = "goods-list">
            <table class = "layui-table fixed-table">
                <thead>
                    <tr>
                        <th>物品名称</th>
                        <th>分类</th>
                        <th>储物柜</th>
                        <th>供货商</th>
                        <th style = "width:60px; text-align: center;">状态</th>
                        <th style = "width:60px; text-align: center;">数量</th>
                        <th class = "action-td" style = "width:300px;text-align: center;">操作</th>
                    </tr>
                </thead>

                <?php
                foreach ($result as $key => $value) {
                    $html = '<tr>';
                    $html .= '<td>' . $value['goods_name'] . '</td>';
                    $html .= '<td>' . $value['category_name'] . '</td>';
                    $html .= '<td>' . $value['box_name'] . '</td>';
                    $html .= '<td>' . $value['supplier_name'] . '</td>';

                    if ($value['check_status']) {
                        $html .= '<td class = \'center-td\'><span class = \'disabled\'>锁定</span></td>';
                    } else {
                        $html .= '<td class = \'center-td\'><span class = \'enabled\'>正常</span></td>';
                    }

                    $html .= '<td class = \'center-td\'>' . $value['goods_count'] . '</td>';

                    $html .= "<td>";

                    $html .= '<a class = \'action-link\' href = ' . site_url() . '/admin_wh/goods/edit/' . $value['gid'] .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>编辑</a>';

                    $html .= '<a class = \'action-link\' href = ' . site_url() . '/admin_wh/goods/replenish/' . $value['gid'] .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>补货</a>';

                    if (0 == $value['check_status']) {
                        $html .= '<a class = \'action-link\' href = ' . site_url() . '/admin_wh/goods/change/' . $value['gid'] .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>' . '开始盘点' . '</a>';
                    } else {
                        $html .= '<a class = \'action-link layui-bg-red\' href = ' . site_url() . '/admin_wh/goods/check/' . $value['gid'] .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>' . '结束盘点' . '</a>';
                    }

                    if (1 == $value['check_status']) {
                        $html .= '<a class = \'action-link layui-bg-orange\' href = ' . site_url() . '/admin_wh/goods/change/' . $value['gid'] .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>' . '取消盘点' . '</a>';
                    } else {
                        $html .= "";
                    }

                    $html .= '<a class = \'action-link layui-bg-red\' href = ' . site_url() . '/admin_wh/goods/del/' . $value['gid']  .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . ' onclick = "return confirm(\'确认删除？\');">删除</a>';

                    $html .= '</td>';
                    $html .= '</tr>';

                    echo $html;
                }
                ?>
            </table>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
