<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

class Goods extends MY_Controller
{
    /**
     * 表名称
     *
     * @var string
     */
    private $table = 'goods';

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('in');

        $this->load->model('admin_wh/goods_model');
    }

    public function list()
    {

        //分页
        $per_page       = 10;
        $uri_segment    = 4;
        $offset         = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;
        $uri            = '/admin_wh/goods/list';

        /**
         * //TODO  搜索
         */
        $condition = array();

        $result     = $this->goods_model->search($condition, $per_page, $offset);

        $total_rows  = $this->goods_model->get_count_all();
        $this->config_pagination($this->table, $uri, $per_page, $uri_segment, $total_rows);

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'goods-list',
            'con_title'             => '物品列表',
            'result'                => $result
        );

        //Load views file
        $view_page = 'admin_wh/goods_list_view';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add()
    {

        $this->load->model('admin_wh/category_model');
        $this->load->model('admin_wh/box_model');
        $this->load->model('admin_wh/supplier_model');

        $category   = $this->category_model->search();
        $box        = $this->box_model->search();
        $supplier   = $this->supplier_model->search();

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'goods-list',
            'con_title'             => '添加物品',
            'result'                => array('category' => $category, 'box' => $box, 'supplier' => $supplier)
        );

        //Load views file
        $view_page = 'admin_wh/goods_add_view';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function add_do()
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('goods-name', '物品名称', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('category', '分类', 'trim|required|max_length[20]|integer');
            $this->form_validation->set_rules('box', '储物柜', 'trim|required|max_length[20]|integer');
            $this->form_validation->set_rules('supplier', '供应商', 'trim|required|max_length[20]|integer');
            $this->form_validation->set_rules('goods-count', '数量', 'trim|max_length[20]|is_natural_no_zero');

            if ($this->form_validation->run() == false) {
                $this->add();
                return;
            }

            $data = array(
                'goods_name'    => $this->input->post('goods-name'),
                'cid'           => $this->input->post('category'),
                'bid'           => $this->input->post('box'),
                'sid'           => $this->input->post('supplier'),
                'wid'           => $this->session->user_wid,
                'goods_count'   => $this->input->post('goods-count')
            );

            //定义查询条件
            $condition = array('goods_name' =>$data['goods_name']);

            //检测是否已经存在该项
            if (empty($this->goods_model->search($condition))) {
                $result = $this->goods_model->insert($data);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['goods_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/goods/add') . '\'>重新输入</a>';
            }

            //保存入库记录

            $instock_data = array(
                'gid'               => $this->db->insert_id(),
                'in_count'          => $data['goods_count'],
                'record_time'       => time(),
                'nick_name'         => $this->session->user_nickname
            );

            //写入入库记录
            if (isset($result['code']) && $result['code'] === 1) {
                $this->db->insert('instock', $instock_data);
            }

            if (isset($result['code']) && $result['code'] === 1) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/goods/list') . "';
                            }, 500);
                        }
                    });
                </script>
            ";

                $result['msg'] .= $jsHtml;
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '添加物品',
                'msg'                   => $result['msg']
            );

            //删除form_token
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '添加物品',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit($gid = 0, $page = 0)
    {
        $condition = array('gid' => $gid);
        $result = $this->goods_model->search($condition);

        if ($gid && !empty($result)) {
            $this->load->model('admin_wh/category_model');
            $this->load->model('admin_wh/box_model');
            $this->load->model('admin_wh/supplier_model');

            // todo 需要修改查询语句
            $category   = $this->category_model->search();
            $box        = $this->box_model->search();
            $supplier   = $this->supplier_model->search();

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '编辑物品',
                'result'                => array('goods' => $result, 'category' => $category, 'box' => $box, 'supplier' => $supplier)
            );

            //Load views file
            $view_page   = 'admin_wh/goods_edit_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '编辑物品',
                'msg'                   => '未查询到物品信息！'
            );


            //Load views file
            $view_page   = 'message_tip';
        }


        $view_data['page'] = $page;
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function edit_do($gid = 0, $page = 0)
    {
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('goods-name', '物品名称', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('category', '分类', 'trim|required|max_length[20]|integer');
            $this->form_validation->set_rules('box', '储物柜', 'trim|required|max_length[20]|integer');
            $this->form_validation->set_rules('supplier', '供应商', 'trim|required|max_length[20]|integer');

            if ($this->form_validation->run() == false) {
                $this->edit($gid, $page);
                return;
            }

            $data = array(
                'goods_name'    => $this->input->post('goods-name'),
                'cid'           => $this->input->post('category'),
                'bid'           => $this->input->post('box'),
                'sid'           => $this->input->post('supplier')
            );

            //定义查询条件
            $condition = array('gid' => $gid);

            $result = $this->goods_model->search(array('goods_name' => $data['goods_name']));
            //检测是否已经存在该项
            if (empty($result) || $result[0]['gid'] === $gid) {
                $result = $this->goods_model->update($data, $condition);
            } else {
                $result['msg'] = '<b style = \'color:red\'>' . $data['goods_name'] . '</b>已经存在，' . '<a class = \'action-link\' href = \'' . site_url('admin_wh/goods/edit/' . $gid . (empty($page) ? '' : '/' . $page)) . '\'>重新输入</a>';
            }

            if (isset($result['code']) && $result['code'] === 1) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/goods/list' . (empty($page) ? '' : '/' . $page)) . "';
                            }, 500);
                        }
                    });
                </script>
            ";

                $result['msg'] .= $jsHtml;
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '编辑物品',
                'msg'                   => $result['msg']
            );

            //删除form_token
            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '编辑物品',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }

        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    /*
    * 库存补充
    */
    public function replenish($gid = 0, $page = 0)
    {
        $condition = array('gid' => $gid);
        $result = $this->goods_model->search($condition);

        if ($gid && !empty($result)) {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品入库',
                'result'                => $result
            );

            //Load views file
            $view_page   = 'admin_wh/goods_replenish_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品入库',
                'msg'                   => '未查询到物品信息！'
            );

            //Load views file
            $view_page   = 'message_tip';
        }

        $view_data['page'] = $page;
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function replenish_do($gid = 0, $page = 0)
    {
        //防止重复刷新提交表单。
        //检测接收到表单POST的form_token和SESSION中存储的form_token是否一致，相同则为第一次提交表单，不相同则判断为重复提交表单
        if (isset($this->session->form_token) && ($this->session->form_token === $this->input->post('form_token'))) {
            $this->form_validation->set_rules('goods-in-count', '物品数量', 'trim|required|max_length[10]|is_natural_no_zero',
            array(
                'required' => '{field} 不能为空。',
                'max_length[10]' => '{field} 字符长度不能超过{param}。',
                'is_natural_no_zero' => '{field} 必须是大于零的整数。'
                )
            );

            if ($this->form_validation->run() == false) {
                $this->replenish($gid, $page);
                return;
            }

            $condition = array('gid' => $gid);
            $result = $this->goods_model->search($condition);

            $data = array(
                'goods_count'   => $this->input->post('goods-in-count') + $result[0]['goods_count']
            );

            $temp_result = $this->goods_model->update($data, $condition);

            //保存入库记录
            $instock_data = array(
                'gid'               => $gid,
                'in_count'          => $this->input->post('goods-in-count'),
                'record_time'       => time(),
                'nick_name'         => $this->session->user_nickname
            );

            //写入入库记录
            if (isset($temp_result['code']) && $temp_result['code'] === 1) {
                $this->db->insert('instock', $instock_data);

                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/goods/list' . (empty($page) ? '' : '/' . $page)) . "';
                            }, 500);
                        }
                    });
                </script>
            ";
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品入库',
                'msg'                   => $temp_result['code'] ? '更新成功！' . $jsHtml : '更新失败！'
            );

            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品入库',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    /*
    * 物品盘点，锁定物品
    */
    public function change($gid = 0, $page = 0)
    {
        $condition = array('gid' => $gid);
        $result = $this->goods_model->search($condition);

        if ($gid && !empty($result)) {
            if ($result[0]['check_status']) {
                $data = array('check_status' => 0);
            } else {
                $data = array('check_status' => 1);
            }

            $result = $this->goods_model->update($data, $condition);

            redirect(site_url() . '/admin_wh/goods/list' . (empty($page) ? '' : '/' . $page));
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品列表',
                'msg'                   => '未查询到物品信息！'
            );

            //Load views file
            $view_page   = 'message_tip';
            $this->_load_view($this->admin_wh_header, $view_page, $view_data);
        }
    }

    /* 库存盘点结束 */
    public function check($gid = 0, $page = 0)
    {
        $condition = array('gid' => $gid);
        $result = $this->goods_model->search($condition);

        if ($gid && !empty($result)) {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品盘点',
                'result'                => $result
            );

            //Load views file
            $view_page   = 'admin_wh/goods_check_view';
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品盘点',
                'msg'                   => '未查询到物品信息！'
            );

            //Load views file
            $view_page   = 'message_tip';
        }

        $view_data['page'] = $page;

        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    /* 库存盘点结束， 修正物品数量 */
    public function check_do($gid = 0, $page = 0)
    {
        //防止重复刷新提交表单。
        //检测接收到表单POST的form_token和SESSION中存储的form_token是否一致，相同则为第一次提交表单，不相同则判断为重复提交表单
        if (isset($this->session->form_token) && ($this->session->form_token === $this->input->post('form_token'))) {
            $this->form_validation->set_rules('goods-in-count', '物品数量', 'trim|required|max_length[10]|is_natural');

            if ($this->form_validation->run() == false) {
                $this->check($gid, $page);
                return;
            }

            //获取表单提交的物品数量
            $goods_count = $this->input->post('goods-in-count');

            $condition = array('gid' => $gid);
            $result = $this->goods_model->search($condition);

            if ($goods_count !== $result[0]['goods_count']) {
                $this->form_validation->set_rules('notes', '差异说明', 'trim|required|max_length[200]',
                    array('required' => '库存物品数量与盘点实物数量不同，请填写差异说明！')
                );
                if ($this->form_validation->run() == false) {
                    $this->check($gid);
                    return;
                }
            }

            $notes = $this->input->post('notes');

            $data = array(
                'gid'           => $gid,
                'stock_count'   => $result[0]['goods_count'],
                'check_count'   => $goods_count,
                'notes'         => $notes,
                'check_time'    => time(),
                'nick_name'     => $this->session->user_nickname
            );

            //写入盘点记录
            $result = $this->db->insert('checkstock', $data);

            //解除锁定,同时修正数量
            if ($result) {
                if ($goods_count !== $result[0]['goods_count']) {
                    $this->goods_model->update(array('goods_count' => $goods_count), $condition);
                }
                $this->goods_model->update(array('check_status' => 0), $condition);
            }

            if ($result) {
                /* js 自动跳转页面 */
                $jsHtml = "
                <script>
                    $(function(){

                        jump_page();

                        function jump_page () {
                            setTimeout(function(){
                                window.location.href = '" . site_url('admin_wh/goods/list' . (empty($page) ? '' : '/' . $page)) . "';
                            }, 500);
                        }
                    });
                </script>
            ";
            }

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品盘点',
                'msg'                   => $result ? '更新成功！' . $jsHtml : '更新失败！'
            );

            unset($_SESSION['form_token']);
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品盘点',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }

    public function del($gid = 0, $page = 0)
    {
        $result = $this->goods_model->del(array('gid' => $gid));

        if (isset($result['code']) && $result['code'] === 1) {
            /* js 自动跳转页面 */
            $jsHtml = "
            <script>
                $(function(){

                    jump_page();

                    function jump_page () {
                        setTimeout(function(){
                            window.location.href = '" . site_url('admin_wh/goods/list' . (empty($page) ? '' : '/' . $page)) . "';
                        }, 500);
                    }
                });
            </script>
        ";

            $result['msg'] .= $jsHtml;
        }

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'goods-list',
            'con_title'             => '删除物品',
            'msg'                   => $result['msg']
        );
        //Load view
        $view_page   = 'message_tip';
        $this->_load_view($this->admin_wh_header, $view_page, $view_data);
    }
}
