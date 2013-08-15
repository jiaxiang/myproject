<?php
class User {
	
	private $obj;
	const API_KEY = '0d7f3b5dd40324e93b5ee9054179c6bd';
	const SECRET = 'f463e7229505593354b5adafc5298b2d';
	public static $current_userid;
	public static $current_username;
	public function __construct() {
		$this->obj = new Eclass(self::API_KEY, self::SECRET);
	}
	
	public function get_current_userid() {
		return Session::get_instance()->get('es_yb_sig_user');
		//return '33';
	}
	
	public function get_current_sessionkey() {
		return Session::get_instance()->get('es_yb_sig_session_key');
		//return '1312321312';
	}
	
	public function get_current_realinfo() {
		return Session::get_instance()->get('es_yb_sig_realinfo');
		//return array('id'=>'33','name'=>'陆佳翔','username'=>'Sai翔');
	}
	
	public function set_current_userid($userid) {
		Session::get_instance()->set(array('es_yb_sig_user'=>$userid));
	}
	
	public function set_current_sessionkey($sessionkey) {
		Session::get_instance()->set(array('es_yb_sig_session_key'=>$sessionkey));
	}
	
	public function set_current_realinfo() {
		$session_key = $this->get_current_sessionkey();
		$eclass_obj = new Eclass(self::API_KEY, self::SECRET, $session_key);
		$return = $eclass_obj->call_method ( 'User.getRealInfo', array ( ) );
		//var_dump($return);
		Session::get_instance()->set(array('es_yb_sig_realinfo'=>$return['userinfo']));
	}
	
	public function is_login() {
		$current_userid = $this->get_current_userid();
		$current_sessionkey = $this->get_current_sessionkey();
		if (!$current_userid || !$current_sessionkey) {
			return false;
		}
		return true;
	}
}
?>