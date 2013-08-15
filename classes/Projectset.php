<?php
class Projectset extends Obj_SQL{
	
	public function __construct() {
		$this->table_name = 'project_sets';
		$this->obj_sql = new SQL();
	}
	
	public function test1() {
		$data = array(
				array('1','1','1','1','1','1'),
				array('2','2','2','2','2','2'),
				array('3','3','3','3','3','3'),
				array('4','4','4','4','4','4'),
				array('5','5','5','5','5','5'),
				array('6','6','6','6','6','6'),
				);
		$field = array('`pname`','`pyear`','`ptype`','`pprofile`','`puid`','`pusername`');
		//$this->add($data, $field);
		
		//$this->select(array('pid'), array('ptype'=>2,'pyear'=>2), array('pid'=>'DESC'),1);
		
		//$this->update(array('ptype'=>1), array('ptype'=>2));
		
		$this->delete(array('ptype'=>1));
	}
	
	public function creat_projectset($data, $field) {
		return $this->add($data, $field);
	}
	
	public function get_projectset_list() {
		$field_array = array();
		$where_array = array();
		$order_array = array('pid'=>'DESC');
		$return = $this->select($field_array, $where_array, $order_array);
		return $return;
	}
	
	public function get_projectset_by_id($id) {
		$field_array = array();
		$where_array = array('pid'=>$id);
		$order_array = array('pid'=>'DESC');
		$return = $this->select($field_array, $where_array, $order_array);
		return $return;
	}
	
}
?>