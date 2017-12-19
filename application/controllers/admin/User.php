<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*  User controller, deal add\del\edit\search
*/
class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('admin');

        $this->load->model('admin/user_model');
    }

    public function list()
    {
        //分页
        $per_page    = 10;
        $uri_segment = 4;
        $offset = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;

        $result = $this->user_model->get_user_list($per_page, $offset);

        $total_rows = count($this->user_model->get_user_list());
        $this->config_pagination('user', '/admin/user/list/', $per_page, $uri_segment, $total_rows);

        /*
        *   用户信息中的privilege_code字段标识性内容，替换为用户容易可以理解的显示方式
        *   用户拥有的权限为固定的三种，所以循环查找匹配直接标识替换。
        *   当前未做权限管理功能
        */
        foreach ($result as $key => $value) {
            foreach ($value as $sub_key => $sub_value) {
                if ($sub_key == 'privilege_code') {
                    $str = '';
                    $sub_value = str_replace('out', '出库', $sub_value);
                    $sub_value = str_replace('admin', '管理员', $sub_value);
                    $sub_value = str_replace('in', '物品管理员', $sub_value);
                    $result[$key]->$sub_key = $sub_value;
                }
            }
        }

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'user-list',
            'con_title'             => '用户列表',
            'result'                => $result
        );

        //Load views file
        $view_page   = 'admin/user_list_view';
        $this->_load_view($this->admin_header, $view_page, $data);
    }

    /* --------------------------- add --------------------------- */
    public function add()
    {
        // Load model
        $this->load->model('admin/privilege_model');
        $this->load->model('admin/warehouse_model');

        /* Save all privilege items with object */
        $privilege = $this->privilege_model->get_privilege_all();

        /* Save all warehouse items with object */
        $warehouse = $this->warehouse_model->search('warehouse');

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'user-add',
            'con_title'             => '添加用户',
            'privilege'             => $privilege,
            'warehouse'             => $warehouse
        );

        //Load views file
        $view_page   = 'admin/user_add_view';
        $this->_load_view($this->admin_header, $view_page, $view_data);
    }

    /* --------------------------- add_do --------------------------- */
    public function add_do()
    {
        // form check rules
        $config = array(
            array(
                'field' => 'username',
                'label' => '账号名',
                'rules' => 'trim|required|min_length[6]|max_length[20]|alpha_numeric'
            ),
            array(
                'field' => 'nickname',
                'label' => '用户名',
                'rules' => 'trim|required|max_length[20]'
            ),
            array(
                'field' => 'password',
                'label' => '密码',
                'rules' => 'trim|required|min_length[6]|max_length[20]'
            ),
            array(
                'field' => 'privilege[]',
                'label' => '权限',
                'rules' => 'required'
            ),
            array(
                'field' => 'warehouse',
                'label' => '仓库',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            //fail
            $this->add();
            return;
        }

        $privilege_arr = $this->input->post('privilege');
        $privilege_str = '';

        foreach ($privilege_arr as $key => $value) {
            $privilege_str .= $value . '-';
        }

        $privilege_str = rtrim($privilege_str, '-');

        //Encryption Password
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $user = array(
            'username'          => $this->input->post('username'),
            'nick_name'         => $this->input->post('nickname'),
            'userpwd'           => $password,
            'privilege_code'    => $privilege_str,
            'wid'               => $this->input->post('warehouse'),
            'uid'               => MD5(date('Y-m-d H:i:s') . $this->input->post('username'))
            );

        $result = $this->user_model->insert($user);

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'user-add',
            'con_title'             => '添加用户',
            'msg'                   => $result['msg']
        );

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_header, $view_page, $data);
    }

    /* --------------------------- edit --------------------------- */
    public function edit($uid = 0, $page = 0)
    {
        if ($uid && ($result = $this->user_model->get_user_info(array('uid' => $uid)))) {
            // Load model
            $this->load->model('admin/privilege_model');
            $this->load->model('admin/warehouse_model');

            /* Save all privilege items with object */
            $privilege = $this->privilege_model->get_privilege_all();
            /* Save all warehouse items with object */
            $warehouse = $this->warehouse_model->search('warehouse');

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'user-list',
                'con_title'             => '编辑用户',
                'result'                => $result,
                'privilege'             => $privilege,
                'warehouse'             => $warehouse
            );

            //Load views file
            $view_page   = 'admin/user_edit_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'user-list',
                'con_title'             => '编辑用户',
                'msg'                   => '未查询到用户信息！'
            );

            //Load views file
            $view_page   = 'message_tip';
        }

        $view_data['page'] = $page;
        $this->_load_view($this->admin_header, $view_page, $view_data);
    }

    /* --------------------------- edit_do --------------------------- */
    public function edit_do($uid = 0, $page = 0)
    {
        // form check rules
        $config = array(
            array(
                'field' => 'nickname',
                'label' => '用户名',
                'rules' => 'trim|required|max_length[20]'
            ),
            array(
                'field' => 'privilege[]',
                'label' => '权限',
                'rules' => 'required'
            ),
            array(
                'field' => 'warehouse',
                'label' => '仓库',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            //fail
            $this->edit($uid, $page);
            return;
        }

        $privilege_arr = $this->input->post('privilege');
        $privilege_str = '';

        foreach ($privilege_arr as $key => $value) {
            $privilege_str .= $value . '-';
        }

        $privilege_str = rtrim($privilege_str, '-');

        $user = array(
            'nick_name'         => $this->input->post('nickname'),
            'privilege_code'    => $privilege_str,
            'wid'               => $this->input->post('warehouse'),
            );

        $result = $this->user_model->update($user, $uid);

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'user-list',
            'con_title'             => '编辑用户',
            'msg'                   => $result['msg']
        );

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_header, $view_page, $data);
    }

    /**
    *  Change user status, enabled or disabled.
    */
    public function change($uid = 0, $page = 0)
    {

        $result = $this->user_model->get_user_info(array('uid' => $uid));

        if ($uid && $result) {
            if ($result[0]->is_enabled) {
                $user = array('is_enabled' => 0);
            } else {
                $user = array('is_enabled' => 1);
            }

            $this->user_model->update($user, $uid);

            redirect(site_url() . '/admin/user' . ($page ? '/list/' . $page : '/list'));
        }
    }

    public function search()
    {
        //TODO:search user
    }
}
