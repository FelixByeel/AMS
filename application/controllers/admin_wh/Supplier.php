<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
* Supplier controller
*/
class Supplier extends MY_Controller
{
    /**
     * 表名称
     *
     * @var string
     */
    private $table = 'supplier';

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('in');

        $this->load->model('admin_wh/supplier_model');
    }

    public function list()
    {
        //分页
        $per_page       = 10;
        $uri_segment    = 4;
        $offset         = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;
        $uri            = '/admin_wh/supplier/list';
        $total_rows     = $this->supplier_model->get_count_all();

        $this->config_pagination($this->table, $uri, $per_page, $uri_segment, $total_rows);

        //定义查询条件
        $condition = array();

        $view_data = array(
        'title'                 => $this->title,
        'current_page_class'    => 'supplier-list',
        'con_title'             => '供货商列表',
        'result'                => $this->supplier_model->search($condition, $per_page, $offset)
        );

        //Load views file
        $view_page = 'admin_wh/supplier_list_view';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add()
    {
        $view_data = array(
        'title'                 => $this->title,
        'current_page_class'    => 'supplier-list',
        'con_title'             => '添加供货商',
        'old_uri'               => $this->input->get('uri')
        );

        //Load views file
        $view_page = 'admin_wh/supplier_add_view';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add_do()
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('supplier-name', '供应商名称', 'trim|required|max_length[20]');

            if ($this->form_validation->run() == false) {
                $this->add();
                return;
            }

            $data = array(
                'supplier_name' => $this->input->post('supplier-name'),
                'wid'           => $this->session->user_wid
            );

            $condition = array('supplier_name' => $data['supplier_name']);

            //检测是否已经存在该项
            if (empty($this->supplier_model->search($condition))) {
                $result = $this->supplier_model->insert($data);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['supplier_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/supplier/add') . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                if (empty($this->input->get('uri'))) {
                    /* 添加返回 */
                    $result['msg'] .= "<a class = 'action-link' href = " . site_url('admin_wh/supplier/list') . ">返&nbsp;&nbsp;&nbsp;&nbsp;回</a>";
                } else {
                    $result['msg'] .= "<a class = 'action-link' href = " . $this->input->get('uri') . ">返&nbsp;&nbsp;&nbsp;&nbsp;回</a>";
                }
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'supplier-list',
                'con_title'             => '添加供货商',
                'msg'                   => $result['msg']
            );

                //删除form_token
                unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'supplier-list',
                'con_title'             => '添加供货商',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit($sid = 0, $page = 0)
    {

        $condition = array('sid' => $sid);

        $result = $this->supplier_model->search($condition);

        if ($sid && !empty($result)) {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'supplier-list',
                'con_title'             => '编辑供货商',
                'result'                => $result
            );

            //views file
            $view_page   = 'admin_wh/supplier_edit_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'supplier-list',
                'con_title'             => '编辑供货商',
                'msg'                   => '未查询到供货商信息！'
            );

            //views file
            $view_page   = 'message_tip';
        }

        $view_data['page'] = $page;
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit_do($sid = 0, $page = 0)
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('supplier-name', '供应商名称', 'trim|required|max_length[20]');

            if ($this->form_validation->run() == false) {
                $this->edit($sid, $page);
                return;
            }

            $data       = array('supplier_name' => $this->input->post('supplier-name'));

            if (empty($this->supplier_model->search($data))) {
                $result = $this->supplier_model->update($data, array('sid' => $sid));
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['supplier_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/supplier/edit/' . $sid . (empty($page) ? '' : '/' . $page)) . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/supplier/list' . (empty($page) ? '' : '/' . $page)) . "';
                            }, 500);
                        }
                    });
                </script>
            ";

                $result['msg'] .= $jsHtml;
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'supplier-list',
                'con_title'             => '编辑供货商',
                'msg'                   => $result['msg']
            );

            //删除form_token
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'supplier-list',
                'con_title'             => '添加供货商',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function del($sid = 0, $page = 0)
    {
        $condition = array('sid' => $sid);

        $result = $this->supplier_model->del($condition);

        if (isset($result['code']) && $result['code'] === 1) {
            /* js 自动跳转页面 */
            $jsHtml = "
            <script>
                $(function(){

                    jump_page();

                    function jump_page () {
                        setTimeout(function(){
                            window.location.href = '" . site_url('admin_wh/supplier/list' . (empty($page) ? '' : '/' . $page)) . "';
                        }, 500);
                    }
                });
            </script>
        ";

            $result['msg'] .= $jsHtml;
        }

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'supplier-list',
            'con_title'             => '删除供应商',
            'msg'                   => $result['msg']
        );

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }
}
