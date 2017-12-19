<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

class Outstock extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('index/outstock_model');
    }

    public function list()
    {

        $condition = array();

        if (!empty($this->input->get('consumer_code'))) {
            $condition['consumer_code'] = $this->input->get('consumer_code');
        }

        if (!empty($this->input->get('consumer_name'))) {
            $condition['consumer_name'] = $this->input->get('consumer_name');
        }

        if (!empty($this->input->get('computer_barcode'))) {
            $condition['computer_barcode'] = $this->input->get('computer_barcode');
        }

        if (!empty($this->input->get('nick_name'))) {
            $condition['nick_name'] = $this->input->get('nick_name');
        }

        $per_page    = 10;  //每页显示记录数
        $uri_segment = 4;   //url中的页码位置
        $offset = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;

        $result['record']   = $this->outstock_model->search($condition, $per_page, $offset);
        $result['search']   = $condition;    //保存搜索条件

        $total_rows         = $this->outstock_model->get_count_all($condition);
        $this->config_pagination('outstock', '/index/outstock/list/', $per_page, $uri_segment, $total_rows);

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'outstock-list',
            'con_title'             => '出库记录',
            'result'                => $result,
        );

        //Load views file
        $content_page = 'index/outstock_list_view';
        $this->_load_view($this->index_header, $content_page, $view_data);
    }

    //查看详细
    public function more()
    {
        $record_id = empty($this->input->post('record_id')) ? 0 : $this->input->post('record_id');

        $condition = array('id' => $record_id);

        $result = $this->outstock_model->search($condition);

        echo json_encode($result);
    }
}
