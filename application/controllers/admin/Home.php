<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*后台控制器
*/
class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('admin');
    }

    public function index()
    {
        $data['title'] = 'demo';
        $data['content'] = 'admin';
        $data['current_page_class'] = 'home-page';

        $user_privilege = 'admin';

        $this->load->view('admin/admin_header_view', $data);
        $this->load->view('admin/admin_home_view', $data);
        $this->load->view('footer_view');
    }
}
