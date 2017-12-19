<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*
*/
class Home extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('out');
    }

    public function index()
    {
        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'home-page',
            'con_title'             => '首页',
            'result'               => 'welcome!'
        );

        //Load views file
        $view_page   = 'index/home_view';
        $this->_load_view($this->index_header, $view_page, $view_data);
    }
}
