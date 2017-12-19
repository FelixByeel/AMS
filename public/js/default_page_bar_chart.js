; (function () {

    /* =================== 请求库存数据,绘制柱形图 ======================== */

    var myChart = echarts.init(document.getElementById('count'));

    myChart.showLoading({
        text: "图表数据正在加载..."
    });

    var option = {
        color: ['#3398DB'],
        title: {
            text: '库存统计',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data: ['库存数量']
        },
        toolbox: {
            show: true,
            feature: {
                restore: { show: true },
                saveAsImage: { show: true }
            }
        },
        grid: {
            left: '3%',
            right: '3%',
            bottom: '10%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                axisTick: {
                    alignWithLabel: true,
                },
                axisLabel: {
                    interval: 0,
                    rotate: 30
                },
                data: []
            }
        ],
        yAxis: [
            {
                type: 'value',
                minInterval: 1
            }
        ],
        series: [
            {
                name: "库存数量",
                type: 'bar',
                barWidth: '25%',
                data: []
            }
        ]
    };

    $.post("../chart/home_chart/get_bar_data", function (data) {
        option.xAxis[0].data = data.name;
        option.series[0].data = data.count;
        myChart.hideLoading();
        myChart.setOption(option);
    }, 'json');
}());
