<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '电脑型号列表' ?>
    </p>
    <div class = "content">
        <div class = "action-header">
            <span class = "link-header">
                <a class = "action-link" href="<?php echo site_url() . '/admin_wh/computer/add'; ?>">添加电脑型号</a>
            </span>
        </div>
        <div class = "computer-list">
            <table class = "layui-table fixed-table">
                <thead>
                    <tr>
                        <th>电脑型号</th>
                        <th style = "text-align: center;">操作</th>
                    </tr>
                </thead>

                <?php
                foreach ($result as $key => $value) {
                    echo '<tr><td>';
                    echo $value['type_name'];
                    echo '</td>';
                    echo '<td class = \'center-td\'>';
                    echo '<a class = \'action-link\' href = ' . site_url() . '/admin_wh/computer/edit/' . $value['typeid'] .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>编辑</a>';

                    echo '<a class = \'action-link layui-bg-red\' href = ' . site_url() . '/admin_wh/computer/del/' . $value['typeid']  .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . ' onclick = "return confirm(\'确认删除？\');">删除</a>';

                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
