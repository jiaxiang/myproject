<?php
class projectController extends Controller{
	
	private $obj;
	private $obj_projectset;
	private $obj_collegename;
	public function __construct() {
		parent::__construct();
		$this->obj = new Project();
		$this->obj_projectset = new Projectset();
		$this->obj_collegename = new College_name();
	}
	
	public function index() {
		//$this->plist();
	}
	
	public function pcreat() {
		$pid = getRequest('pid');
		$proset_info = $this->obj_projectset->get_projectset_by_id($pid);
		$college_list = $this->obj_collegename->get_college_list();
		$prompt = '';
		if ($_POST) {
			//var_dump($_POST);
			$college_id = getRequest('college');
			$college_info = $this->obj_collegename->get_college_by_id($college_id);
			if ($college_info == false) {
				$prompt = $this->_site_lan['creat_project_college_error'];
			}
			else {
				$user_info = $this->obj_user->get_current_realinfo();
				$name = trim(getRequest('name'));
				$type = trim(getRequest('type'));
				$source = trim(getRequest('source'));
				$level = trim(getRequest('level'));
				$over_expect = trim(getRequest('over_expect'));
				$report_way = trim(getRequest('report_way'));
				$realname = trim(getRequest('realname'));
				$teacher_name = trim(getRequest('teacher_name'));
				if ($name == '' || $type == '' || $source == '' || $level == '' || $over_expect == ''
						 || $report_way == '' || $realname == '' || $teacher_name == '') {
					$prompt = $this->_site_lan['creat_project_field_error'];
				}
				else {
					$data = array(
							'"'.$proset_info[0]['pid'].'"',
							'"'.$name.'"',
							'"'.$type.'"',
							'"'.$source.'"',
							'"'.$level.'"',
							'"'.$over_expect.'"',
							'"'.$report_way.'"',
							'"'.$college_info[0]['name'].'"',
							'"'.$realname.'"',
							'"'.$teacher_name.'"',
							'"'.$user_info['id'].'"',
							'"'.$user_info['username'].'"'
							);
					$field = array('`pid`','`name`','`type`','`source`','`level`','`over_expect`','`report_way`'
							,'`college`','`realname`','`teacher_name`','`userid`','`username`');
					$result = $this->obj->creat_project($data, $field);
					if ($result == true) {
						$prompt = $this->_site_lan['creat_project_success'];
					}
					else {
						$prompt = $this->_site_lan['creat_project_insert_error'];
					}
				}
			}
		}
		$data = array('site_config'=>$this->_site_config, 'projectset'=>$proset_info[0], 
				'college'=>$college_list, 'prompt' => $prompt);
		View::get_instance()->rander('project/creat', $data);
	}
	
	public function plist() {
		$pid = getRequest('pid');
		$list = $this->obj->get_project_list_by_pid($pid);
		$projectset = $this->obj_projectset->get_projectset_by_id($pid);
		$data = array('site_config'=>$this->_site_config, 'data'=>$list, 'projectset'=>$projectset[0]);
		View::get_instance()->rander('project/list', $data);
	}
	
	public function pshow() {
		$id = getRequest('id');
		$list = $this->obj->get_project_detail_by_id($id);
		$data = array('site_config'=>$this->_site_config, 'data'=>$list[0]);
		View::get_instance()->rander('project/show', $data);
	}
}
?>