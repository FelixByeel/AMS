<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>

<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '分类列表'; ?>
    </p>
    <div class = "content">
        <div class = "action-header">
            <span class = "link-header">
                <a class = "action-link" href="<?php echo site_url() . '/admin_wh/category/add'; ?>">添加分类</a>
            </span>
        </div>

        <hr class="layui-bg-grey">

        <div id = "category_list" class = "category-list">

        <?php

        echo get_tree($result, 0, '', 0);

        function get_tree($data, $pid, $html, $deep)
        {
            $flag = 1;
            $html = '<ul class = \'parent_' . $pid . ' parent\'>';

            foreach ($data as $key => $value) {
                if ($value['pid'] == $pid) {
                    $html .= '<li class = \'cate_' . $value['cid'] . ' child\'>';

                    $str = '';
                    for ($i = 0; $i < $deep; $i++) {
                        $str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&brvbar;';
                    }

                    $str .= '-- ';

                    $html .= '<span class = \'c-split\'>' . $str;
                    $html .= '<span class = \'c-name\'>' . $value['category_name'] . '</span>';

                    $html .= '<span class = \'center-td action\'>';
                    $html .= '<a class = \'action-link\' href = ' . site_url() . '/admin_wh/category/edit/' . $value['cid'] . '>编辑</a>';
                    $html .= '<a class = \'action-link layui-bg-red\' href = ' . site_url() . '/admin_wh/category/del/' . $value['cid'] . ' onclick = "return confirm(\'确认删除？\');">删除</a></span>';
                    $html .= '</span>';

                    $deep += 1;
                    $html .= get_tree($data, $value['cid'], $html, $deep);
                    $deep -= 1;
                    $html .= '</li>';

                    $flag = 0;
                }
            }

            if ($flag) {
                $position = strripos($html, '<ul');
                $html = substr_replace($html, '', $position);
            } else {
                $html .= '</ul>';
            }

            return $html;
        }

        ?>

        </div>
    </div>
</div>
