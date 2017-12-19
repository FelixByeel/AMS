<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>

<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '权限列表' ?>
    </p>
    <div class = "content">
        <div class = "search-wrapper"></div>
        <div class = "privilege-list">
            <!--
            <p class = 'note' style = "color:red" >说明：当前只提供以下3种固定权限供选择，一个用户可以同时拥有多个权限，但至少有一个权限。out--拥有物品出库权限；in--拥有物品管理权限；admin--拥有仓库管理、用户管理权限。</p>
            -->
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>权限编码</th>
                        <th>权限名称</th>
                    </tr>
                </thead>

                <?php
                foreach ($result as $key => $value) {
                    echo '<tr><td>';
                    echo $value->privilege_code;
                    echo '</td><td>';
                    echo $value->privilege_name;
                    echo '</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</div>
