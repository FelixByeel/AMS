<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
* Category controller
*/
class Category extends MY_Controller
{

    /**
     * 定义默认数据表名称
     *
     * @var string
     */
    private $table = 'category';

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('in');

        $this->load->model('admin_wh/category_model');
    }

    public function list()
    {

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'cate-list',
            'con_title'             => '分类列表',
            'result'                => $this->category_model->search()
        );

        //Load views file
        $view_page   = 'admin_wh/category_list_view';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add()
    {
        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'cate-list',
            'con_title'             => '添加分类',
            'result'                => $this->category_model->search(),
            'old_uri'               => $this->input->get('uri')
        );

        //Load views file
        $view_page   = 'admin_wh/category_add_view';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add_do()
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('category-name', '分类名称', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('parent-category', '上级分类', 'trim|max_length[20]');

            if ($this->form_validation->run() == false) {
                $this->add();
                return;
            }

            $data = array(
                'category_name' => $this->input->post('category-name'),
                'pid'           => empty($this->input->post('parent-category')) ? 0 : $this->input->post('parent-category'),
                'wid'           => $this->session->user_wid
            );

            //定义查询条件
            $condition = array('category_name' => $data['category_name']);

            //检测是否已经存在该项
            if (empty($this->category_model->search($condition))) {
                $result = $this->category_model->insert($data);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['category_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/category/add') . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                if (empty($this->input->get('uri'))) {
                    /* js 自动跳转页面 */
                    /*
                    $jsHtml = "
                        <script>
                            $(function(){

                                jump_page();

                                function jump_page () {
                                    setTimeout(function(){
                                        window.location.href = '" . site_url('admin_wh/category/list') . "';
                                    }, 500);
                                }
                            });
                        </script>
                        ";
                        */

                    $result['msg'] .= "<a class = 'action-link' href = " . site_url('admin_wh/category/list') . ">返&nbsp;&nbsp;&nbsp;&nbsp;回</a>";
                } else {
                    $result['msg'] .= "<a class = 'action-link' href = " . $this->input->get('uri') . ">返&nbsp;&nbsp;&nbsp;&nbsp;回</a>";
                }
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'cate-list',
                'con_title'             => '添加分类',
                'msg'                   => $result['msg']
            );

            //删除form_token
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'cate-list',
                'con_title'             => '添加分类',
                'msg'                   => '请不要重复刷新页面提交表单！'
                );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit($cid = 0)
    {
        //定义查询条件
        $condition = array('cid' => $cid);
        $result = $this->category_model->search($condition);

        if ($cid && !empty($result)) {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'cate-list',
                'con_title'             => '编辑分类',
                'result'                => array('current_cate' => $result, 'category' => $this->category_model->search())
            );

            //views file
            $view_page = 'admin_wh/category_edit_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'cate-list',
                'con_title'             => '编辑分类',
                'msg'                   => '未查询到分类信息！'
            );

            //views file
            $view_page   = 'message_tip';
        }

        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit_do($cid = 0)
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('category-name', '分类名称', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('parent-category', '上级分类', 'trim|max_length[20]');

            if ($this->form_validation->run() === false) {
                $this->edit($cid);
                return;
            }

            $data = array(
                'category_name' => $this->input->post('category-name'),
                'pid'           => empty($this->input->post('parent-category')) ? 0 : $this->input->post('parent-category')
            );

            $result = $this->category_model->search(array('category_name' => $data['category_name']));


            //检测是否已经存在该项
            if (empty($result)) {
                $result = $this->category_model->update($data, array('cid' => $cid));
            } elseif ($result[0]['cid'] == $cid) {
                $result = $this->category_model->update($data, array('cid' => $cid));
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['category_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/category/edit/' . $cid) . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/category/list') . "';
                            }, 500);
                        }
                    });
                </script>
            ";

                $result['msg'] .= $jsHtml;
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'cate-list',
                'con_title'             => '编辑分类',
                'msg'                   => $result['msg']
            );

            //删除form_token
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'cate-list',
                'con_title'             => '添加分类',
                'msg'                   => '请不要重复刷新页面提交表单！'
                );
        }

        //Load view
        $view_page = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function del($cid = 0)
    {
        $condition = array('cid' => $cid);

        $result = $this->category_model->del($condition);

        if (isset($result['code']) && $result['code'] === 1) {
            /* js 自动跳转页面 */
            $jsHtml = "
            <script>
                $(function(){

                    jump_page();

                    function jump_page () {
                        setTimeout(function(){
                            window.location.href = '" . site_url('admin_wh/category/list') . "';
                        }, 500);
                    }
                });
            </script>
        ";

            $result['msg'] .= $jsHtml;
        } elseif ($result['code'] === -2) {
            $result['msg'] .= "<a class = 'action-link' href = " . site_url('admin_wh/category/list') . ">返&nbsp;&nbsp;&nbsp;&nbsp;回</a>";
        }

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'cate-list',
            'con_title'             => '删除分类',
            'msg'                   => $result['msg']
        );

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }
}
