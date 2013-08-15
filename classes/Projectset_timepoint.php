<?php
class Projectset_timepoint extends Obj_SQL {
	
	public function __construct() {
		$this->table_name = 'project_time_points';
		$this->obj_sql = new SQL();
	}
	
	public function get_timepoint_by_pid($pid) {
		$field_array = array();
		$where_array = array('pid'=>$pid);
		$order_array = array('id'=>'DESC');
		$return = $this->select($field_array, $where_array, $order_array);
		return $return;
	}
}
?>