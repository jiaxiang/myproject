<?php
class Controller {
	
	public $obj_user;
	public $_site_config;
	public $_site_lan;
	public function __construct() {
		$this->obj_user = new User();
		if (getRequest('yb_sig_user')) {
			$current_userid = getRequest('yb_sig_user');
			$session_key = getRequest('yb_sig_session_key');
			if (!$this->obj_user->get_current_sessionkey()) {
				$this->obj_user->set_current_sessionkey($session_key);
			}
			if (!$this->obj_user->get_current_userid()) {
				$this->obj_user->set_current_userid($current_userid);
			}
			if (!$this->obj_user->get_current_realinfo()) {
				$this->obj_user->set_current_realinfo();
			}
		}
		if ($this->obj_user->is_login() == false) {
			//die('login first!');
		}
		
		globalConfig('site_config');
		global $site_config;
		$this->_site_config = $site_config;
		
		globalConfig('lan');
		global $lan;
		$this->_site_lan = $lan;
	}
	
}
?>