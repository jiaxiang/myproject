<?php
class Session {
	protected static $protect = array('session_id', 'user_agent');
	private static $instance = NULL;
	
	public static function get_instance(){
		if(self::$instance === null){
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}
	
	public function set($keys, $val = false) {
		if (empty($keys)) {
			return FALSE;
		}
		
		if ( ! is_array($keys)) {
			$keys = array($keys => $val);
		}
		
		foreach ($keys as $key => $val) {
			if (isset(Session::$protect[$key])) {
				continue;
			}
			$_SESSION[$key] = $val;
		}
	}
	
	public function get($key = false, $default = FALSE) {
		$result = NULL;
		if (empty($key)) {
			return $_SESSION;
		}
		if (isset($_SESSION[$key])) {
			$result = $_SESSION[$key];
		}
		return ($result === NULL) ? $default : $result;
	}
	
	public function delete($key) {
		$args = func_get_args();
		
		foreach ($args as $key) {
			if (isset(Session::$protect[$key])) {
				continue;
			}
			unset($_SESSION[$key]);
		}
	}
}
?>