<?php
class Obj_SQL {
	
	protected $obj_sql;
	protected $table_name;
	const MAX_INSERT_ROWS = 2000;
	
	public function __construct() {
		$this->obj_sql = new SQL();
	}
	
	/**
	 * 
	 * @param array $data $data = array(
				array('1','1','1','1','1','1'),
				array('2','2','2','2','2','2'),
				array('3','3','3','3','3','3'),
				array('4','4','4','4','4','4'),
				array('5','5','5','5','5','5'),
				array('6','6','6','6','6','6'),
				);
	 * @param array $field array('`pname`','`pyear`','`ptype`','`pprofile`','`puid`','`pusername`');
	 */
	public function add($data, $field) {
		$field_query = implode(',', $field);
		$field_query = '('.$field_query.') values ';
		$total_count = count($data);
		$return = false;
		if ($total_count > self::MAX_INSERT_ROWS) {
			$new_data = array_chunk($data, self::MAX_INSERT_ROWS);
			$return_flag = 0;
			for ($i = 0; $i < count($new_data); $i++) {
				$insert_sql_query = 'insert into `'.$this->table_name.'` '.$field_query;
				$value_query = array();
				for ($j = 0; $j < count($new_data[$i]); $j++) {
					$t = implode(',', $new_data[$i][$j]);
					$value_query[] = '('.$t.')';
				}
				$value_query = implode(',', $value_query);
				$insert_sql_query .= $value_query;
				//echo $insert_sql_query;
				$this->obj_sql->query($insert_sql_query);
				if (!$this->obj_sql->error()) {
					$return_flag ++;
				}
			}
			if ($return_flag == $new_data) {
				$return = true;
			}
		}
		else {
			$insert_sql_query = 'insert into `'.$this->table_name.'` '.$field_query;
			$value_query = array();
			var_dump($data);die();
			for ($i = 0; $i < count($data); $i++) {
				$t = implode(',', $data[$i]);
				$value_query[] = '('.$t.')';
			}
			$value_query = implode(',', $value_query);
			$insert_sql_query .= $value_query;
			//echo $insert_sql_query;
			$this->obj_sql->query($insert_sql_query);
			if (!$this->obj_sql->error()) {
				$return = true;
			}
		}
		return $return;
	}
	
	public function add_single($data, $field) {
		$field_query = implode(',', $field);
		$field_query = '('.$field_query.') values ';
		$insert_sql_query = 'insert into `'.$this->table_name.'` '.$field_query;
		$value_query = array();
		//var_dump($data);die();
		$t = implode(',', $data);
		//$value_query[] = '('.$t.')';
		$value_query = '('.$t.')';
		//$value_query = implode(',', $value_query);
		$insert_sql_query .= $value_query;
		//echo $insert_sql_query;
		$this->obj_sql->query($insert_sql_query);
		if (!$this->obj_sql->error()) {
			$return = $this->obj_sql->insert_id();
		}
		else {
			$return = false;
		}
		return $return;
	}
	
	/**
	 * 
	 * @param array $field array('id','name')
	 * @param array $where array('id'=>3, 'name'=>'xxx')
	 * @param array $order array('id'=>'DESC')
	 * @param int $limit 1 
	 */
	public function select($field, $where, $order, $limit = null) {
		if (!is_array($field) || count($field) <= 0) {
			$field_query = '*';
		}
		else {
			$field_query = implode(',', $field);
		}
		$where_query = ' where 1=1';
		foreach ($where as $key => $val) {
			$where_query .= ' and `'.$key.'` = "'.$val.'"';
		}
		$order_query = ' order by ';
		foreach ($order as $key => $val) {
			$order_query .= ' `'.$key.'` '.$val.' ,';
		}
		$order_query = substr($order_query, 0, -1);
		$limit_query = '';
		if ($limit != null && $limit > 0) {
			$limit_query = ' limit '.$limit;
		}
		$select_sql_query = 'select '.$field_query.' from `'.$this->table_name.'`'.$where_query.$order_query.$limit_query;
		$this->obj_sql->query($select_sql_query);
		$return = array();
		while ($a = $this->obj_sql->fetch_array()) {
			$return[] = $a;
		}
		return $return;
	}
	
	/**
	 * 
	 * @param array $data array('name'=>'xxx')
	 * @param array $where array('id'=>3)
	 */
	public function update($data, $where) {
		$set_query = ' ';
		foreach ($data as $key => $val) {
			$set_query .= ' `'.$key.'` = "'.$val.'" ,';
		}
		$set_query = substr($set_query, 0, -1);
		$where_query = ' where ';
		foreach ($where as $key => $val) {
			$where_query .= ' `'.$key.'` = "'.$val.'" and';
		}
		$where_query = substr($where_query, 0, -3);
		$update_sql_query = 'update `'.$this->table_name.'` set'.$set_query.$where_query;
		//echo $update_sql_query;
		$this->obj_sql->query($update_sql_query);
		if (!$this->obj_sql->error()) {
			return true;
		}
		return false;
	}
	
	public function delete($where) {
		$where_query = ' where ';
		foreach ($where as $key => $val) {
			$where_query .= ' `'.$key.'` = "'.$val.'" and';
		}
		$where_query = substr($where_query, 0, -3);
		$del_sql_query = 'delete from `'.$this->table_name.'`'.$where_query;
		echo $del_sql_query;
		$this->obj_sql->query($del_sql_query);
		if (!$this->obj_sql->error()) {
			return true;
		}
		return false;
	}
	
}