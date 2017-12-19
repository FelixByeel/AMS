<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*User model
*/
class User_model extends CI_Model
{
    /**
    * @param int $per_page
    * @param int $offset
    * @return object or NULL
    */
    public function get_user_list($per_page = 0, $offset = 0)
    {
        $this->db->order_by('username', 'ASC');
        $this->db->join('warehouse', 'user.wid = warehouse.wid', 'left');
        $query = $this->db->get('user', $per_page, $offset);
        return $query->result();
    }

    /**
    *@param array $condition  array(key => value)
    *@return object or NULL
    */
    public function get_user_info($condition)
    {
        $this->db->join('warehouse', 'user.wid = warehouse.wid', 'left');
        $query = $this->db->get_where('user', $condition);
        return $query->result();
    }

    /**
    * return action status
    *
    * @param array $data
    * @return array
    */
    public function insert($data)
    {
        if (!$this->get_user_info(array('username' => $data['username']))) {
            if ($this->db->insert('user', $data)) {
                $status['code'] = 1;
                $status['msg'] = '添加成功！';
                return $status;
            } else {
                $status['code'] = 0;
                $status['msg'] = '添加失败！';
                return $status;
            }
        } else {
                $status['code'] = -1;
                $status['msg'] = '<b style = \'color:red\'>' . $data['username'] . '</b> 已经存在，请重新输入！';
                return $status;
        }
    }

    /**
    * return action status
    *
    * @param array $data
    * @param string $uid
    * @return array
    */
    public function update($data, $uid)
    {
        if ($this->db->update('user', $data, array('uid' => $uid))) {
            $status['code'] = 1;
            $status['msg'] = '更新成功！';
            return $status;
        } else {
            $status['code'] = 0;
            $status['msg'] = '更新失败！';
            return $status;
        }
    }
}
