<?php
class College_name extends Obj_SQL {
	
	public function __construct() {
		$this->table_name = 'college_names';
		$this->obj_sql = new SQL();
	}
	
	public function get_college_list() {
		$field_array = array();
		$where_array = array();
		$order_array = array('code'=>'ASC');
		$return = $this->select($field_array, $where_array, $order_array);
		return $return;
	}
	
	public function get_college_by_id($id) {
		$field_array = array();
		$where_array = array('id'=>$id);
		$order_array = array('id'=>'DESC');
		$return = $this->select($field_array, $where_array, $order_array);
		return $return;
	}
}
?>