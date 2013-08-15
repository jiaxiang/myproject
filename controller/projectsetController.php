<?php
class projectsetController extends Controller{
	
	private $obj;
	private $obj_timepoint;
	public function __construct() {
		parent::__construct();
		$this->obj = new Projectset();
		$this->obj_timepoint = new Projectset_timepoint();
	}
	
	public function index() {
		$this->plist();
	}
	
	public function pcreat() {
		if ($_POST) {
			$data = array();
			$field = array('`pname`','`pyear`','`ptype`','`pprofile`','`puid`','`pusername`');
			$this->obj->creat_projectset($data, $field);
		}
	}
	
	public function plist() {		
		//$_SESSION['test'] = '123';
		$list = $this->obj->get_projectset_list();
		$data = array('site_config'=>$this->_site_config, 'data'=>$list);
		View::get_instance()->rander('projectset/list', $data);
	}
	
	public function pshow() {
		//var_dump($_SESSION['test']);
		$id = getRequest('id');
		$list = $this->obj->get_projectset_by_id($id);
		$data = array('site_config'=>$this->_site_config, 'data'=>$list[0]);
		View::get_instance()->rander('projectset/show', $data);
	}
}
?>