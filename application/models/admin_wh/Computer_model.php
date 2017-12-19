<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
* @author Felix
*/
class Computer_model extends CI_Model
{

    /**
    * 定义默认数据表名称
    *
    */
    private $table = 'computer';

    /**
    * 查询
    *
    * @param array  $condition      条件
    * @param int    $limit          要查询的记录数
    * @param int    $offset         查询偏移量
    * @return array
    */
    public function search($condition = array(), $limit = 0, $offset = 0)
    {

        $condition['is_deleted']    = 0;
        $condition['wid']           = $this->session->user_wid;

        $query = $this->db->get_where($this->table, $condition, $limit, $offset);

        return $query->result_array();
    }

    /**
    * @param array      $data
    * @return array
    */
    public function insert($data = array())
    {

        if (empty($data)) {
            $status['code'] = -1;
            $status['msg'] = '无效数据！';
        } elseif ($this->db->insert($this->table, $data)) {
            $status['code'] = 1;
            $status['msg'] = '添加成功！';
        } else {
            $status['code'] = 0;
            $status['msg'] = '添加失败！';
        }

        return $status;
    }

    /**
    * @param array $data
    * @param array $condition   update condition
    * @return array The action status and message
    */
    public function update($data = array(), $condition = array())
    {

        if (empty($data) || !isset($condition['typeid']) || empty($this->search($condition))) {
            $status['code'] = -1;
            $status['msg'] = '无效数据！';
        } elseif ($this->db->update($this->table, $data, $condition)) {
            $status['code'] = 1;
            $status['msg'] = '更新成功！';
        } else {
            $status['code'] = 0;
            $status['msg'] = '更新失败！';
        }

        return $status;
    }

    /**
    * @param    array      $condition
    * @return   array
    */
    public function del($condition = array())
    {

        if (!isset($condition['typeid']) || empty($this->search($condition))) {
            $status['code'] = -1;
            $status['msg'] = '无效数据！';
        } elseif ($this->update(array('is_deleted' => 1), $condition)) {
            $status['code'] = 1;
            $status['msg'] = '删除成功！';
        } else {
            $status['code'] = 0;
            $status['msg'] = '删除失败！';
        }

        return $status;
    }

    /**
    * 返回表中的总记录数。
    *
    * @param    array       $condition
    * @return   int
    */
    public function get_count_all($condition = array('is_deleted' => 0))
    {
        return count($this->search($condition));
    }
}
