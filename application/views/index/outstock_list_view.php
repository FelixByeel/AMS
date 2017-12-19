<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);
?>
<div class = "content-wrapper">
    <p class = "con-title">
        <?php echo isset($con_title) ? $con_title : '出库记录' ?>
    </p>
    <div class = "content">
        <div class = "outstock-search search-form layui-form-item">

            <div class="layui-inline">
                <label class="search-label">工号</label>
                <div class="layui-inline" style = "width:100px;">
                    <input type="text" name="consumer-code" id="consumer_code" autocomplete="off" class="layui-input" style = "display:inline-block; height:30px; line-height:30px;" value = "<?php echo empty($result['search']['consumer_code']) ? '' : $result['search']['consumer_code']; ?>">
                </div>
            </div>

            <div class="layui-inline">
                <label class="search-label">资产条码</label>
                <div class="layui-inline" style = "width:150px;">
                    <input type="text" name="computer-barcode" id="computer_barcode" autocomplete="off" class="layui-input" style = "display:inline-block; height:30px; line-height:30px;" value = "<?php echo empty($result['search']['computer_barcode']) ? '' : $result['search']['computer_barcode']; ?>">
                </div>
            </div>

            <div class="layui-inline">
                <label class="search-label">处理人</label>
                <div class="layui-inline" style = "width:100px;">
                    <input type="text" name="nick_name" id="nick_name" autocomplete="off" class="layui-input" style = "display:inline-block; height:30px; line-height:30px;" value = "<?php echo empty($result['search']['nick_name']) ? '' : $result['search']['nick_name']; ?>">
                </div>
            </div>

            <div class="layui-inline">
                <div class="layui-inline" style = "width:80px;">
                    <button class = "layui-btn" style = "height:30px; line-height:30px;" id = "out_search_btn">搜索</button>
                </div>

                <div class="layui-inline" style = "width:80px;">
                    <button class = "layui-btn layui-bg-red" style = "height:30px; line-height:30px;" id = "out_reset_btn">重置</button>
                </div>
            </div>
        </div>
        <div class = "outstock-list">
            <table class = "layui-table fixed-table">
                <thead>
                    <tr class = "tr-head">
                        <th><b>物品名称</b></th>
                        <!--<th><b>物品序列号</b></th>
                        <th><b>供应商</b></th>-->
                        <th><b>工号</b></th>
                        <th><b>电脑型号</b></th>
                        <th><b>电脑资产条码</b></th>
                        <th style = "width:60px; text-align: center;"><b>数量</b></th>
                        <th style = "width:150px; text-align: center;"><b>日期</b></th>
                        <th style = "width:60px; text-align: center;"><b>处理人</b></th>
                        <th style = "width:60px; text-align: center;"><b>操作</b></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result['record'] as $key => $value) {
                    $html = '<tr>';
                    $html .= '<td>' . $value['goods_name'] . '</td>';
                    //$html .= '<td>' . $value['goods_sn'] . '</td>';
                    //$html .= '<td>' . $value['supplier_name'] . '</td>';
                    $html .= '<td>' . $value['consumer_code'] . '</td>';
                    $html .= '<td>' . $value['type_name'] . '</td>';
                    $html .= '<td>' . $value['computer_barcode'] . '</td>';
                    $html .= '<td class = \'center-td\'>' . $value['out_count'] . '</td>';
                    $html .= '<td class = \'center-td\'>' . date('Y-m-d H:i:s', $value['record_time']) . '</td>';
                    $html .= '<td class = \'center-td\'>' . $value['nick_name'] . '</td>';
                    $html .= '<td class = \'center-td\'><button class="layui-btn layui-btn-small" onclick="view_more(' . $value['id'] . ')">更多</button></td>';
                    $html .='</tr>';

                    echo $html;
                }
                ?>
                </tbody>
            </table>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>

<!--弹出层，显示更多信息 -->
<div id="outDetail" class="layui-container" style="display:none; width:100%; height:90%; padding:7% 6%;">

    <div class="layui-row">
        <div class="layui-col-md1">
            <label class = "label-name">工号：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "user_code" class = "span-content"></span>
        </div>

        <div class="layui-col-md1">
            <label class = "label-name">日期：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "record_time" class = "span-content"></span>
        </div>
    </div>

    <hr class="layui-bg-gray">

    <div class="layui-row">
        <div class="layui-col-md1">
            <label class = "label-name">物品名称：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "goods_name" class = "span-content"></span>
        </div>
        <div class="layui-col-md1">
            <label class = "label-name">物品序列号：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "goods_sn" class = "span-content"></span>
        </div>
        <div class="layui-col-md1">
            <label class = "label-name">供应商：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "supplier_name" class = "span-content"></span>
        </div>
    </div>

    <hr class="layui-bg-gray">

    <div class="layui-row">
        <div class="layui-col-md1">
            <label class = "label-name">电脑型号：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "type_name" class = "span-content"></span>
        </div>
        <div class="layui-col-md1">
            <label class = "label-name">电脑序列号：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "computer_sn" class = "span-content"></span>
        </div>
        <div class="layui-col-md1">
            <label class = "label-name">资产条码：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "computer_code" class = "span-content"></span>
        </div>
    </div>

    <hr class="layui-bg-gray">

    <div class="layui-row">
        <div class="layui-col-md1">
            <label class = "label-name">数量：</label>
        </div>
        <div class="layui-col-md2">
            <span id = "out_count" class = "span-content"></span>
        </div>
    </div>

    <hr class="layui-bg-gray">

    <div class="layui-row">
        <div class="layui-col-md1">
            <label class = "label-name">处理人：</label>
        </div>
        <div class="layui-col-md3">
            <span id = "deal_name" class = "span-content"></span>
        </div>
    </div>

    <hr class="layui-bg-gray">
</div>

<script>

    function view_more(record_id) {
        var post_uri = window.location.href;
        post_uri = post_uri.split('list')[0];

        $.post(post_uri + 'more', {'record_id' : record_id}, function(data){

            $("#user_code").html(data[0]['consumer_code']);
            $("#goods_name").html(data[0]['goods_name']);
            $("#goods_sn").html(data[0]['goods_sn']);
            $("#supplier_name").html(data[0]['supplier_name']);
            $("#type_name").html(data[0]['type_name']);
            $("#computer_sn").html(data[0]['computer_sn']);
            $("#computer_code").html(data[0]['computer_barcode']);
            $("#out_count").html(data[0]['out_count']);

            var record_time = new Date(parseInt(data[0]['record_time']) * 1000);
            $("#record_time").html(formatDate(record_time, "yyyy-MM-dd HH:mm:ss"));
            $("#deal_name").html(data[0]['nick_name']);

            layui.use('layer', function(){
                var layer = layui.layer;
                layer.open({
                    area:['90%', '80%'],
                    skin:"layui-layer-molv",
                    title:"详细信息",
                    type:1,
                    content:$("#outDetail")
                });
            });

            console.log('------------------------------------');
            console.log(data);
            console.log('------------------------------------');
        }, 'json');
    }
</script>
