<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*  Loing controller
*/
class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('admin_wh/login_view_new');
    }

    /**
    *  处理用户登录
    */
    public function do()
    {
        $this->load->model('admin/user_model');

        //获取登录信息
        $user_login_data = $this->input->post('data');

        //查询出当前登录用户的信息
        $user_db_data = $this->user_model->get_user_info(array('username' => $user_login_data['username']));

        if (!empty($user_db_data)) {
            if ($user_db_data[0]->is_enabled) {
                if (password_verify($user_login_data['password'], $user_db_data[0]->userpwd)) {
                    //password verify correct, get user infomation.
                    $this->session->user_uid       = $user_db_data[0]->uid;
                    $this->session->user_name      = $user_db_data[0]->username;
                    $this->session->user_nickname  = $user_db_data[0]->nick_name;
                    $this->session->user_privilege = explode('-', $user_db_data[0]->privilege_code);
                    $this->session->user_wid       = $user_db_data[0]->wid;
                    $this->session->user_warehouse_name = $user_db_data[0]->warehouse_name;

                    if (in_array('admin', $this->session->user_privilege)) {
                        $uri = site_url('/admin/home');
                    } elseif (in_array('in', $this->session->user_privilege)) {
                        $uri = site_url('/admin_wh/home');
                    } else {
                        print(json_encode(array('status' => '用户名或密码错误！')));
                        $this->session->sess_destroy();
                        exit();
                    }

                    //记录登录时间
                    $this->user_model->update(array('last_time' => time()), $this->session->user_uid);

                    $data = array(
                        'status'    => 'success',
                        'url'       => $uri
                    );

                    print(json_encode($data));
                } else {
                    print(json_encode(array('status' => '用户名或密码错误！')));
                    exit();
                }
            } else {
                print(json_encode(array('status' => '当前帐号已停用！')));
                exit();
            }
        } else {
            print(json_encode(array('status' => '用户名或密码错误！')));
            exit();
        }
    }
}
