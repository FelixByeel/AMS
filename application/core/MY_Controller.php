<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*  Define custom controller
*/
class MY_Controller extends CI_Controller
{
    /**
    * @var string Common header of admin
    */
    protected $admin_header   = 'admin/admin_header_view';

    /**
    * @var string Common header of admin_warehouse
    */
    protected $admin_wh_header   = 'admin_wh/admin_wh_header_view';

    /**
    * @var string Common header of index
    */
    protected $index_header   = 'index/header_view';

    /**
    * @var string Title of the page
    */
    protected $title         = '资产管理系统';

    public function __construct()
    {
        parent::__construct();

        //is login?
        if (!isset($this->session->user_uid) or empty($this->session->user_uid)) {
            redirect(base_url());
        }
    }

    /**
    *  Load view
    *
    * @param string $header_page        header page path
    * @param string $content_page       content page path
    * @param array  $data               this array will send to view page, it include two default key, title and current_page_class is required
    * @return void
    */
    protected function _load_view($header_page, $content_page, $data = array('title' => 'demo', 'current_page_class' => 'home'))
    {
        $this->load->view($header_page, $data);
        $this->load->view($content_page, $data);
        $this->load->view('footer_view');
    }

    /**
    * Check the privilege code, if it not exist in user's privilege code then show a message and exit this application.
    * @param string privilege_code
    * @return void
    */
    protected function verify_privilege($privilege_code)
    {
        if (!in_array($privilege_code, $this->session->user_privilege)) {
            $message = "<div style = 'margin: 50px; padding: 10px; height: 25px; line-height: 25px;
                    border:1px solid #CCC; box-shadow: 0 1px 5px 1px #D0D0D0;
                    font-family: Arial, Helvetica, sans-serif, Microsoft YaHei;
                    font-size:14px; color: #666'>You do not have permission to access！</div>";
            exit($message);
        }
    }

    /**
    * Config pagination
    * @param string $table_name
    * @param string $uri        This is a point of your pagination page's full URL of the controller class/method
    * @param int $per_page
    * @param int $uri_segment
    * @return void
    */
    protected function config_pagination($table_name, $uri, $per_page, $uri_segment, $total_rows)
    {
        $this->load->library('pagination');

        //分页配置
        $config['base_url']         = site_url() . $uri;
        $config['per_page']         = $per_page;
        $config['uri_segment']      = $uri_segment;
        $config['total_rows']       = $total_rows;

        $config['use_page_numbers'] = true;
        $config['reuse_query_string'] = true;


        $config['full_tag_open']    = '<div class = \'page-wrapper\'>';
        $config['full_tag_close']   = '</di>';

        $config['first_link']       = "<i class='layui-icon'>&#xe65a;</i>";
        $config['first_tag_open']   = '<span class = \'first-link display-block page-height page-width\' title = \'首页\'>';
        $config['first_tag_close']  = '</span>';

        $config['last_link']        = "<i class='layui-icon'>&#xe65b;</i>";
        $config['last_tag_open']    = '<span class = \'last-link display-block page-height page-width\'  title = \'尾页\'>';
        $config['last_tag_close']   = '</span>';

        $config['prev_link']        = "<i class='layui-icon'>&#xe603;</i>";
        $config['prev_tag_open']    = '<span class = \'prev-link display-block page-height page-width\' title = \'上一页\'>';
        $config['prev_tag_close']   = '</span>';

        $config['next_link']        = "<i class='layui-icon'>&#xe602;</i>";
        $config['next_tag_open']    = '<span class = \'next-link display-block page-height page-width\' title = \'下一页\'>';
        $config['next_tag_close']   = '</span>';

        $config['cur_tag_open']     = '<span class = \'cur-link display-block page-height page-width\'>';
        $config['cur_tag_close']    = '</span>';

        $config['num_tag_open']     = '<span class = \'num-link display-block page-height page-width\'>';
        $config['num_tag_close']    = '</span>';

        $config['attributes'] = array('class' => 'page-link display-block page-height page-width');

        $this->pagination->initialize($config);
    }
}
