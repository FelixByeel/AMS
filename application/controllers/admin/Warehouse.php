<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*  Warehouse controller, deal add\del\edit\search
*/
class Warehouse extends MY_Controller
{

    /**
    * 定义默认数据表名称
    *
    */
    private $table = 'warehouse';

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('admin');

        $this->load->model('admin/warehouse_model');
    }

    public function list()
    {
        //分页
        $per_page       = 10;
        $uri_segment    = 4;
        $offset         = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;
        $uri            = '/admin/warehouse/list';
        $total_rows     = $this->warehouse_model->get_count_all($this->table);

        $this->config_pagination($this->table, $uri, $per_page, $uri_segment, $total_rows);

        //定义查询条件
        $condition = array();

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'wh-list',
            'con_title'             => '仓库列表',
            'result'                => $this->warehouse_model->search($this->table, $condition, $per_page, $offset)
        );

        //Load views file
        $view_page   = 'admin/warehouse_list_view';
        $this->_load_view($this->admin_header, $view_page, $view_data);
    }

    /**
    *  Show add warehouse page
    */
    public function add()
    {
        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'wh-add',
            'con_title'             => '添加仓库',
        );

        //Load views file
        $view_page   = 'admin/warehouse_add_view';
        $this->_load_view($this->admin_header, $view_page, $view_data);
    }

    /**
    *  Check data from view's form, and insert it to database
    */
    public function add_do()
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('wh-name', '仓库名称', 'trim|required|max_length[20]');
            $wh_name = $this->input->post('wh-name');

            if ($this->form_validation->run() == false) {
                $this->add();
                return;
            }

            $data = array(
                'warehouse_name' => $this->input->post('wh-name')
            );

            //定义查询条件
            $condition = $data;

            //检测是否已经存在该项
            if (empty($this->warehouse_model->search($this->table, $condition))) {
                $result = $this->warehouse_model->insert($this->table, $data);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['warehouse_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin/warehouse/add') . '\'>重新输入</a>';
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'wh-add',
                'con_title'             => '添加仓库',
                'msg'                   => $result['msg']
            );
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'wh-add',
                'con_title'             => '添加仓库',
                'msg'                   => '请勿刷新页面重复提交表单！'
            );
        }

        //Load view
        $view_page   = 'message_tip';

        $this->_load_view($this->admin_header, $view_page, $view_data);
    }

    public function edit($wid = 0)
    {

        $condition = array('wid' => $wid);

        $result = $this->warehouse_model->search($this->table, $condition);

        if ($wid && !empty($result)) {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'wh-list',
                'con_title'             => '编辑仓库',
                'result'                => $result
            );

            //Load views file
            $view_page   = 'admin/warehouse_edit_view';

            $this->_load_view($this->admin_header, $view_page, $view_data);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'wh-list',
                'con_title'             => '编辑仓库',
                'msg'                   => '未查询到仓库信息！'
            );

            //Load views file
            $view_page   = 'message_tip';

            $this->_load_view($this->admin_header, $view_page, $view_data);
        }
    }

    public function edit_do($wid = 0)
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('wh-name', '仓库名称', 'trim|required|max_length[20]');
            $wh_name = $this->input->post('wh-name');

            if ($this->form_validation->run() == false) {
                $this->edit($wid);
                return;
            }

            $condition  = array('wid' => $wid);

            $data       = array('warehouse_name' => $wh_name);

            if (empty($this->warehouse_model->search($this->table, $data))) {
                $result = $this->warehouse_model->update($this->table, $data, $condition);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['warehouse_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin/warehouse/edit/' . $wid) . '\'>重新输入</a>';
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'wh-list',
                'con_title'             => '编辑仓库',
                'msg'                   => $result['msg']
            );

            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'wh-list',
                'con_title'             => '编辑仓库',
                'msg'                   => '请勿刷新页面重复提交表单！'
            );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_header, $view_page, $view_data);
    }

    public function del($wid = 0)
    {

        $condition = array('wid' => $wid);

        $result = $this->warehouse_model->del($this->table, $condition);

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'wh-list',
            'con_title'             => '删除仓库',
            'msg'                   => $result['msg']
        );

        //Load view
        $view_page   = 'message_tip';

        $this->_load_view($this->admin_header, $view_page, $view_data);
    }
}
