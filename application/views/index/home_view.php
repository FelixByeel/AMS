<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">

    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '首页' ?>
    </p>
    <div class = "content">
        <!-- 首页折线图 -->
        <div id = "checkout" style = "padding:20px 20px 0 20px;min-width:500px; height:350px;"></div>

        <hr>

        <!-- 首页柱形图 -->
        <div id = "count" style = "padding:20px 20px 20px 20px;min-width:500px; height:400px;"></div>

        <!-- 图表加载相关js -->
        <script src = "<?php echo base_url("public/js/default_page_line_chart.js?v=1.0"); ?>"></script>
        <script src = "<?php echo base_url("public/js/default_page_bar_chart.js?v=1.0"); ?>"></script>

        <!-- 自动刷新页面 -->
        <script>
            function refresh_page(){
            window.location.reload();
            }
            setTimeout('refresh_page()',1000 * 60 * 10); //10分钟刷新一次
        </script>
    </div>
</div>
