<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

class Computer extends MY_Controller
{

    /**
     * 表名称
     *
     * @var string
     */
    private $table = 'computer';

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('in');

        $this->load->model('admin_wh/computer_model');
    }

    public function list()
    {
        //分页配置参数
        $per_page       = 10;
        $uri_segment    = 4;
        $offset         = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;
        $uri            = '/admin_wh/computer/list';
        $total_rows     = $this->computer_model->get_count_all();

        $this->config_pagination($this->table, $uri, $per_page, $uri_segment, $total_rows);

        //定义查询条件
        $condition = array();

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'computer-list',
            'con_title'             => '电脑型号列表',
            'result'                => $this->computer_model->search($condition, $per_page, $offset)
        );

        //Load views file
        $view_page = 'admin_wh/computer_list_view';

        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add()
    {
        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'computer-list',
            'con_title'             => '添加电脑型号'
        );

        //Load views file
        $view_page = 'admin_wh/computer_add_view';

        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add_do()
    {
        //防止重复刷新提交表单。
        //检测session中是否存在form_token，判断接收到表单POST的form_token和SESSION中存储的form_token是否一致，相同则为第一次提交表单，不相同则判断为重复提交表单
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('type-name', '电脑型号名称', 'trim|required|max_length[20]');

            if ($this->form_validation->run() == false) {
                $this->add();
                return;
            }

            $data = array(
                'type_name' => $this->input->post('type-name'),
                'wid'       => $this->session->user_wid
            );

            //定义查询条件
            $condition = array('type_name' => $data['type_name']);

            //检测是否已经存在该项
            if (empty($this->computer_model->search($condition))) {
                $result = $this->computer_model->insert($data);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['type_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/computer/add') . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/computer/list') . "';
                            }, 500);
                        }
                    });
                </script>
            ";

                $result['msg'] .= $jsHtml;
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'computer-list',
                'con_title'             => '添加电脑型号',
                'msg'                   => $result['msg']
            );

            //删除form_token
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'computer-list',
                'con_title'             => '添加电脑型号',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    /**
     * edit
     *
     * @param int $typeid computer type id
     */
    public function edit($typeid = 0, $page = 0)
    {

        $condition = array('typeid' => $typeid);

        $result = $this->computer_model->search($condition);

        if ($typeid && !empty($result)) {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'computer-list',
                'con_title'             => '编辑电脑型号',
                'result'                => $result
            );

            //Load views file
            $view_page   = 'admin_wh/computer_edit_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'computer-list',
                'con_title'             => '编辑电脑型号',
                'msg'                   => '未查询到电脑型号信息！'
            );

            //Load views file
            $view_page   = 'message_tip';
        }

        $view_data['page'] = $page;
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit_do($typeid = 0, $page = 0)
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('type-name', '电脑型号名称', 'trim|required|max_length[20]');
            $type_name = $this->input->post('type-name');

            if ($this->form_validation->run() == false) {
                $this->edit($typeid, $page);
                return;
            }

            $condition  = array('typeid' => $typeid);

            $data       = array('type_name' => $type_name);

            if (empty($this->computer_model->search($data))) {
                $result = $this->computer_model->update($data, $condition);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['type_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/computer/edit/' . $typeid . (empty($page) ? '' : '/' . $page)) . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/computer/list' . (empty($page) ? '' : '/' . $page)) . "';
                            }, 500);
                        }
                    });
                </script>
            ";

                $result['msg'] .= $jsHtml;
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'computer-list',
                'con_title'             => '编辑电脑型号',
                'msg'                   => $result['msg']
            );

            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'computer-list',
                'con_title'             => '编辑电脑型号',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function del($typeid = 0, $page = 0)
    {

        $condition = array('typeid' => $typeid);

        $result = $this->computer_model->del($condition);

        if (isset($result['code']) && $result['code'] === 1) {
            /* js 自动跳转页面 */
            $jsHtml = "
            <script>
                $(function(){

                    jump_page();

                    function jump_page () {
                        setTimeout(function(){
                            window.location.href = '" . site_url('admin_wh/computer/list' . (empty($page) ? '' : '/' . $page)) . "';
                        }, 500);
                    }
                });
            </script>
        ";

            $result['msg'] .= $jsHtml;
        }

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'computer-list',
            'con_title'             => '删除电脑型号',
            'msg'                   => $result['msg']
        );

        //Load view
        $view_page   = 'message_tip';

        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }
}
