<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

class Goods extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->verify_privilege('out');
        $this->load->model('admin_wh/goods_model');
    }

    public function list()
    {
        //分页
        $per_page    = 10;
        $uri_segment = 4;
        $offset = ((empty($this->uri->segment($uri_segment)) ? 1 : $this->uri->segment($uri_segment)) -1 ) * $per_page;

        //TODO 按搜索条件
        $condition  = array();

        $result     = $this->goods_model->search($condition, $per_page, $offset);

        $total_rows  = $this->goods_model->get_count_all();
        $this->config_pagination('goods', '/index/goods/list/', $per_page, $uri_segment, $total_rows);

        $view_data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'goods-list',
            'con_title'             => '物品列表',
            'result'                => $result
        );

        //Load views file
        $view_page = 'index/goods_list_view';
        $this->_load_view($this->index_header, $view_page, $view_data);
    }

    public function checkout($gid = 0, $page = 0)
    {
        $condition = array('gid' => $gid);
        $goods = $this->goods_model->search($condition);

        //查询电脑型号信息
        $this->load->model('admin_wh/computer_model');
        $computer_type = $this->computer_model->search();

        if ($gid && $goods) {
            if ($goods[0]['check_status']) {
                $view_data = array(
                    'title'                 => $this->title,
                    'current_page_class'    => 'goods-list',
                    'con_title'             => '物品出库',
                    'msg'                   => '当前物品正在盘点中，无法出库！'
                );

                //Load views file
                $view_page   = 'message_tip';
            } else {
                $view_data = array(
                    'title'                 => $this->title,
                    'current_page_class'    => 'goods-list',
                    'con_title'             => '物品出库',
                    'result'                => array('goods' => $goods, 'computer_type' => $computer_type)
                );

                //Load views file
                $view_page   = 'index/goods_out_view';
            }
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品出库',
                'msg'                   => '未查询到物品信息！'
            );

            //Load views file
            $view_page   = 'message_tip';
        }

        $view_data['page'] = $page;
        $this->_load_view($this->index_header, $view_page, $view_data);
    }

    public function checkout_do($gid = 0, $page = 0)
    {

        //防止重复刷新提交表单。
        //检测接收到表单POST的form_token和SESSION中存储的form_token是否一致，相同则为第一次提交表单，不相同则判断为重复提交表单
        if (isset($this->session->form_token) and $this->session->form_token === $this->input->post('form_token')) {
            $this->form_validation->set_rules('goods-sn', '物品序列号', 'trim|alpha_numeric|max_length[20]');
            $this->form_validation->set_rules('consumer-code', '工号', 'trim|required|alpha_numeric|min_length[6]|max_length[20]');
            $this->form_validation->set_rules('computer-type', '电脑型号', 'trim|max_length[20]');
            $this->form_validation->set_rules('computer-sn', '电脑序列号', 'trim|alpha_numeric|max_length[20]');
            $this->form_validation->set_rules('computer-barcode', '电脑资产条码', 'trim|is_natural_no_zero|min_length[12]|max_length[12]');
            $this->form_validation->set_rules('checkout-count', '出库数量', 'trim|required|is_natural_no_zero|max_length[20]');

            if ($this->form_validation->run() == false) {
                $this->checkout($gid, $page);
                return;
            }

            //callback_check_result,调用自定义验证函数,验证库存数量是否足够出库。
            $this->form_validation->set_rules('checkout-count', '', 'callback_check_result[' . $gid . ']');

            if ($this->form_validation->run() == false) {
                $this->checkout($gid, $page);
                return;
            }

            $condition = array('gid' => $gid);
            $result = $this->goods_model->search($condition);

            $data = array(
                'gid'               => $result[0]['gid'],
                'goods_sn'          => strtoupper($this->input->post('goods-sn')),
                'out_count'         => $this->input->post('checkout-count'),
                'consumer_code'     => $this->input->post('consumer-code'),
                'typeid'            => strtoupper($this->input->post('computer-type')),
                'computer_sn'       => strtoupper($this->input->post('computer-sn')),
                'computer_barcode'  => $this->input->post('computer-barcode'),
                'record_time'       => time(),
                'nick_name'         => $this->session->user_nickname
            );

            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品出库',
                'msg'                   => ''
            );

            $goods_count = $result[0]['goods_count'] - $this->input->post('checkout-count');

            if (!$result[0]['check_status'] && $this->goods_model->update(array('goods_count' => $goods_count), $condition) && $this->db->insert('outstock', $data)) {
                //操作成功后删除form_token
                unset($_SESSION['form_token']);

                /* js 自动跳转页面 */
                $jsHtml = "
                    <script>
                        $(function(){

                            jump_page();

                            function jump_page () {
                                setTimeout(function(){
                                    window.location.href = '" . site_url('index/goods/list' . (empty($page) ? '' : '/' . $page)) . "';
                                }, 500);
                            }
                        });
                    </script>
                ";

                $view_data['msg'] = '出库成功!' . $jsHtml;
            } else {
                $view_data['msg'] = '出库失败!';
                //回滚数据
                $this->goods_model->update(array('goods_count' => $result[0]['goods_count']), $condition);
            }
        } else {
            $view_data = array(
                'title'                 => $this->title,
                'current_page_class'    => 'goods-list',
                'con_title'             => '物品出库',
                'msg'                   => '请不要重复刷新页面提交表单！'
            );
        }
        //Load views file
        $view_page   = 'message_tip';
        $this->_load_view($this->index_header, $view_page, $view_data);
    }

    /**
    * 自定义表单验证
    *
    * @param int $check_count   表单输入物品数量
    * @param int $gid           当前物品gid
    * @return bool
    */
    public function check_result($check_count, $gid = 0)
    {
        $condition = array('gid' => $gid);
        $result = $this->goods_model->search($condition);

        if ($gid && $result) {
            if ($result[0]['goods_count'] - $check_count < 0) {
                $this->form_validation->set_message('check_result', '库存不足，请修改出库数量！');
                return false;
            } else {
                return true;
            }
        } else {
            echo '出库异常，请重新操作！';
            die();
        }
    }
}
