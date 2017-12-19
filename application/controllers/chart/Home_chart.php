<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

class Home_chart extends MY_Controller
{
    //返回首页折线图数据
    public function get_line_data()
    {
        $this->load->model('index/outstock_model');

        //获取最近$months个月的月份
        $date_arr   = array();
        $months     = 6;

        for ($i = 0; $i < $months; $i++) {
            if (!$i) {
                $date_arr[$i] = date('Y-m');
            } else {
                $date_arr[$i] = $this->getLastMonth($date_arr[$i - 1]);
            }
        }

        //查询$date_arr保存的月份的记录数
        $condition  = array('record_time > ' => strtotime($date_arr[count($date_arr) - 1]));

        $result     = $this->outstock_model->search($condition);

        //初始化
        $goods      = array();

        foreach ($result as $key => $value) {
            for ($i = 0; $i < count($date_arr); $i++) {
                $goods[$value['gid']]['count'][$i] = 0;
            }
            $goods[$value['gid']]['name'] = $value['goods_name'];
        }

        //对物品分类按月出库记录统计数量
        foreach ($result as $key => $value) {
            for ($i = 0; $i < count($date_arr); $i++) {
                $start_time = strtotime($date_arr[$i]);
                $end_time   = $i ? strtotime($date_arr[$i - 1]) : time();

                if ($value['record_time'] > $start_time && $value['record_time'] < $end_time) {
                    $goods[$value['gid']]['count'][$i] += $value['out_count'];
                }
            }
        }

        $goods_obj['name']      = array();
        $goods_obj['data']      = array();
        $goods_obj['months']    = $date_arr;

        foreach ($goods as $key => $value) {
            //krsort($value['count']);

            array_push($goods_obj['name'], $value['name']);
            array_push($goods_obj['data'], $value['count']);
        }

        echo json_encode($goods_obj);
    }

    //返回首页柱状图数据
    public function get_bar_data()
    {
        $this->load->model('admin_wh/goods_model');

        $result = $this->goods_model->search();

        $count['name'] = array();
        $count['count'] = array();
        foreach ($result as $key => $value) {
            array_push($count['name'], $value['goods_name']);
            array_push($count['count'], $value['goods_count']);
        }

        echo json_encode($count);
    }

    //根据当前月份获取上月
    private function getLastMonth($dateStr)
    {
        $year   = explode('-', $dateStr)[0];
        $month  = explode('-', $dateStr)[1];

        if (1 == $month) {
            $month  = 12;
            $year   -= 1;
        } else {
            $month  -= 1;
        }

        if ($month < 10) {
            return $year . '-' . '0' . $month;
        }
        return $year . '-' . $month;
    }
}
