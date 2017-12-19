(function () {

    /* =================== 请求出库记录数据,绘制折线图 ======================== */

    var myChart = echarts.init(document.getElementById('checkout'));

    myChart.showLoading({
        text: "图表数据正在加载..."
    });

    var option = {
        title: {
            text: '出库统计',
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: []
        },
        toolbox: {
            show: true,
            feature: {
                magicType: { show: true, type: ['line', 'bar'] },
                restore: { show: true },
                saveAsImage: { show: true }
            }
        },
        grid: {
            left: '3%',
            right: '3%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: []
            }
        ],
        yAxis: [
            {
                type: 'value',
                minInterval: 1
            }
        ],
        series: []
    };

    $.post("../chart/home_chart/get_line_data", function (data) {

        var item = function () {
            return {
                name: "",
                type: "line",
                data: []
            }
        };

        var legends = [];
        var series = [];

        for (var i = 0; i < data.name.length; i++) {
            var it = new item();
            legends.push(data.name[i]);

            it.name = data.name[i];
            it.data = data.data[i].reverse(); //reverse() 方法用于颠倒数组中元素的顺序。

            series.push(it);
        }

        option.xAxis[0].data = data.months.reverse();
        option.legend.data = legends;
        option.series = series;

        myChart.hideLoading();
        myChart.setOption(option);

    }, 'json');
}());
