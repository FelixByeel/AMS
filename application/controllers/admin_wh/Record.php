<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
* 记录查询
*/
class Record extends MY_Controller
{
    private $_header_page    = 'admin_wh/admin_wh_header_view';

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('in');
    }

    public function record_in()
    {
        $per_page    = 10;  //每页显示记录数
        $uri_segment = 4;   //url中的页码位置
        $offset = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;

        $this->db->order_by('record_time', 'DESC');
        $this->db->join('goods', 'instock.gid = goods.gid', 'left');
        $this->db->join('supplier', 'goods.sid = supplier.sid', 'left');

        $result   = $this->db->get_where('instock', array('goods.wid' => $this->session->user_wid), $per_page, $offset);

        $this->db->order_by('record_time', 'DESC');
        $this->db->join('goods', 'instock.gid = goods.gid', 'left');
        $this->db->join('supplier', 'goods.sid = supplier.sid', 'left');

        $total_rows         = count($this->db->get_where('instock', array('goods.wid' => $this->session->user_wid))->result_array());

        $this->config_pagination('instock', '/admin_wh/record/record_in', $per_page, $uri_segment, $total_rows);

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'record-in',
            'con_title'             => '入库记录',
            'result'                => $result->result_array()
        );

        //Load views file
        $content_page   = 'admin_wh/record_in_view';
        $this->_load_view($this->_header_page, $content_page, $data);
    }

    public function record_check()
    {
        $per_page    = 10;  //每页显示记录数
        $uri_segment = 4;   //url中的页码位置
        $offset = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;

        $this->db->order_by('check_time', 'DESC');
        $this->db->join('goods', 'checkstock.gid = goods.gid', 'left');
        $this->db->join('supplier', 'goods.sid = supplier.sid', 'left');

        $result = $this->db->get_where('checkstock', array('goods.wid' => $this->session->user_wid), $per_page, $offset);

        $this->db->join('goods', 'checkstock.gid = goods.gid', 'left');
        $this->db->join('supplier', 'goods.sid = supplier.sid', 'left');

        $total_rows = count($this->db->get_where('checkstock', array('goods.wid' => $this->session->user_wid))->result_array());

        $this->config_pagination('checkstock', '/admin_wh/record/record_check', $per_page, $uri_segment, $total_rows);

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'record-check',
            'con_title'             => '盘点记录',
            'result'                => $result->result_array()
        );

        //Load views file
        $content_page   = 'admin_wh/record_check_view';
        $this->_load_view($this->_header_page, $content_page, $data);
    }
}
