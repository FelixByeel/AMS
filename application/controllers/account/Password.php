<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
* Change password
*/
class Password extends MY_Controller
{
    public function index()
    {


        $old_uri = $this->input->get('uri');

        $view_data = array(
        'title'                 => $this->title,
        'current_page_class'    => 'password-change',
        'con_title'             => '修改密码',
        'old_uri'               =>$old_uri
        );
        //Load views file
        $view_page   = 'account/password/password_change_view';
        $this->_load_view('account/password/header_view', $view_page, $view_data);
    }

    public function change()
    {

        $this->load->model('admin/user_model');

        $this->form_validation->set_rules('old-password', '旧密码', 'trim|required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('new-password', '新密码', 'trim|required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('confirm-password', '确认新密码', 'trim|required|min_length[6]|max_length[20]|matches[new-password]');


        if ($this->form_validation->run() == false) {
            $this->index($this->input->get('uri'));
            return;
        }

        $this->form_validation->set_rules('old-password', 'old password', 'callback_check_pwd');

        if ($this->form_validation->run() == false) {
            $this->index($this->input->get('uri'));
            return;
        }

        $new_pwd = password_hash($this->input->post('new-password'), PASSWORD_DEFAULT);

        $user = array('userpwd' => $new_pwd);
        $result = $this->user_model->update($user, $this->session->user_uid);

        $js = "<script>
                    alert(\"密码修改成功！点击'确定'按钮重新登录。\");
                    window.setTimeout(\"window.location='" . site_url() . '/logout' . "'\",0);
                </script>";

        $data = array(
            'title'                 => $this->title,
            'current_page_class'    => 'password-change',
            'con_title'             => '修改密码',
            'msg'                   => $result['code'] ? $js : $result['msg']
        );

        //Load view
        $content_page   = 'message_tip';
        $this->_load_view('account/password/header_view', $content_page, $data);
    }

    /**
    * 自定义表单验证
    *
    * @return bool
    */
    public function check_pwd()
    {

        $old_pwd = $this->input->post('old-password');

        $user_data = $this->user_model->get_user_info(array('uid' => $this->session->user_uid));

        if (password_verify($old_pwd, $user_data[0]->userpwd)) {
            return true;
        } else {
            $this->form_validation->set_message('check_pwd', '旧密码输入错误！');
            return false;
        }
    }
}
