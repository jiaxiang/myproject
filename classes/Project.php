<?php
class Project extends Obj_SQL {
	
	private $obj_psql;
	public function __construct() {
		$this->table_name = 'projects';
		$this->obj_sql = new SQL();
		$this->obj_psql = new Page_SQL();
	}
	
	public function creat_project($data, $field) {
		return $this->add_single($data, $field);
	}
	
	public function get_project_list_by_pid($pid) {
		$field = '*';
		$where = 'where `pid`="'.$pid.'"';
		$order = 'order by id DESC';
		$this->obj_psql->offset = 100;
		$data = $this->obj_psql->runSQL($this->table_name, $field, $where, $order);
		$this->obj_psql->fullPageLink_new();
		$pagelist = $this->obj_psql->pagelink;
		$return = array('data'=>$data, 'page'=>$pagelist);
		return $return;
	}
	
	public function get_project_detail_by_id($id) {
		$field_array = array();
		$where_array = array('id'=>$id);
		$order_array = array('id'=>'DESC');
		$return = $this->select($field_array, $where_array, $order_array);
		return $return;
	}
	
}
?>