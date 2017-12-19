<?php
$tips = "<div style = 'margin:200px 300px; padding: 0 10px; width: 200px; height: 25px; line-height: 25px; border:1px solid #aaa; box-shadow: 0 1px 5px 1px #888;
        font-family: Arial, Helvetica, sans-serif, Microsoft YaHei; font-size:14px; color: #666'>No direct script access allowed!</div>";
defined('BASEPATH') or exit($tips);

/**
* @author Felix
*/
class Outstock_model extends CI_Model
{
    /**
    * 定义默认数据表名称
    *
    */
    private $table = 'outstock';

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

        $this->db->order_by('record_time', 'DESC');

        $condition['outstock.is_deleted']   = 0;
        $condition['goods.wid']             = $this->session->user_wid;

        //多表联查
        $this->db->join('goods', 'outstock.gid = goods.gid', 'left');
        //$this->db->join('category', 'goods.cid = category.cid', 'left');
        $this->db->join('box', 'goods.bid = box.bid', 'left');
        $this->db->join('supplier', 'goods.sid = supplier.sid', 'left');
        $this->db->join('computer', 'outstock.typeid = computer.typeid', 'left');

        //限定查询字段
        $this->db->select('outstock.*, goods.goods_name, supplier.supplier_name, computer.type_name');

        $query = $this->db->get_where($this->table, $condition, $limit, $offset);

        return $query->result_array();
    }

    /**
    * 返回表中的总记录数。
    *
    * @param    array       $condition
    * @return   int
    */
    public function get_count_all($condition = array())
    {

        return count($this->search($condition));
    }
}
