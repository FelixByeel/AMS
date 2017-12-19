<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

//TODO
//! 注意：当前未实现权限管理功能，默认只提供查看权限功能。

/**
*  Privilege controller
*
*/
class Privilege extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('admin');
    }

    public function index()
    {

        $this->load->model('admin/privilege_model');
        $result = $this->privilege_model->get_privilege_all();

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'privilege-list',
            'con_title'             => '权限列表',
            'result'                => $result
        );

        //Load views file
        $content_page   = 'admin/privilege_list_view';
        $this->_load_view($this->admin_header, $content_page, $data);
    }

    public function add()
    {
        # code...
    }

    public function add_do()
    {
        # code...
    }

    public function edit()
    {
        # code...
    }

    public function edit_do()
    {
        # code...
    }

    public function del()
    {
        # code...
    }
}
