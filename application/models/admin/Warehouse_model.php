<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
*Warehouse model
*/
class Warehouse_model extends CI_Model
{
    /**
    * 定义默认数据表名称
    *
    */
    private $table = 'warehouse';

    /**
    * 查询
    *
    * @param string $table     表名
    * @param array  $condition      条件
    * @param int    $limit          要查询的记录数
    * @param int    $offset         查询偏移量
    * @return array
    */
    public function search($table, $condition = array(), $limit = 0, $offset = 0)
    {
        if (empty($table)) {
            $table = $this->table;
        }

        $condition['is_deleted'] = 0;

        $query = $this->db->get_where($table, $condition, $limit, $offset);

        return $query->result_array();
    }

    /**
    * @param string     $table
    * @param array      $data
    * @return array
    */
    public function insert($table, $data = array())
    {

        if (empty($table)) {
            $table = $this->table;
        }

        if (empty($data)) {
            $status['code'] = -1;
            $status['msg'] = '无效数据！';
        } elseif ($this->db->insert($table, $data)) {
            $status['code'] = 1;
            $status['msg'] = '添加成功！';
        } else {
            $status['code'] = 0;
            $status['msg'] = '添加失败！';
        }

        return $status;
    }

    /**
    * @param string $table
    * @param array $data
    * @param array $condition   update condition
    * @return array The action status and message
    */
    public function update($table, $data = array(), $condition = array())
    {
        if (empty($table)) {
            $table = $this->table;
        }

        if (empty($data) || empty($condition)) {
            $status['code'] = -1;
            $status['msg'] = '无效数据！';
        } elseif ($this->db->update($table, $data, $condition)) {
            $status['code'] = 1;
            $status['msg'] = '更新成功！';
        } else {
            $status['code'] = 0;
            $status['msg'] = '更新失败！';
        }

        return $status;
    }

    /**
    * 删除操作，修改is_deleted字段值，标识删除/未删除
    *
    * @param    string     $table
    * @param    array      $condition
    * @return   array
    */
    public function del($table, $condition = array())
    {
        if (empty($table)) {
            $table = $this->table;
        }

        if (empty($condition) || empty($this->search($table, $condition))) {
            $status['code'] = -1;
            $status['msg'] = '无效数据！';
        } elseif ($this->db->update($table, array('is_deleted' => 1), $condition)) {
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
    * @param    string      $table
    * @param    array       $condition
    * @return   int
    */
    public function get_count_all($table, $condition = array('is_deleted' => 0))
    {
        if (empty($table)) {
            $table = $this->table;
        }

        return count($this->search($table, $condition));
    }
}
