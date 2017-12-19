<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '用户列表'; ?>
    </p>
    <div class = "content">
        <div class = "search-wrapper"></div>
        <div class = "user-list">
            <table class="layui-table fixed-table">
                <thead>
                    <tr>
                        <th>帐号</th>
                        <th>用户昵称</th>
                        <th>操作权限</th>
                        <th>所属仓库</th>
                        <th style = "width:60px; text-align: center;">状态</th>
                        <th>最后登录时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <?php
                foreach ($result as $key => $value) {
                    if ($value->username == 'admin') {
                        continue;
                    }
                    echo '<tr>';

                    echo '<td>';
                    echo "{$value->username}";
                    echo '</td>';

                    echo '<td>';
                    echo "{$value->nick_name}";
                    echo '</td>';

                    echo '<td>';
                    echo "{$value->privilege_code}";
                    echo '</td>';

                    echo '<td>';
                    if (!$value->wid) {
                        echo '-';
                    } else {
                        echo "{$value->warehouse_name}";
                    }
                    echo '</td>';

                    echo '<td class = \'center-td\'>';
                    if ($value->is_enabled) {
                        echo '<span class = \'enabled\'>正常</span>';
                    } else {
                        echo '<span class = \'disabled\'>禁用</span>';
                    }
                    echo '</td>';

                    echo '<td>';
                    if (!$value->last_time) {
                        echo '-';
                    } else {
                        echo date('Y-m-d H:i:s', $value->last_time);
                    }
                    echo '</td>';

                    echo '<td>';
                    echo '<a class = \'action-link\' href = ' . site_url() . '/admin/user/edit/' . $value->uid .
                            (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4)) . '>编辑</a>';

                    $uri = '<a class = \'action-link\' href = ' . site_url() . '/admin/user/change/' . $value->uid . (empty($this->uri->segment(4)) ? '' : '/' . $this->uri->segment(4));
                    if (!$value->is_enabled) {
                        echo $uri . ' style = \'background-color: #00BFFF\'>启用</a>';
                    } else {
                        echo $uri . ' style = \'background-color: #FF5722\'>禁用</a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
