<?php
class View {
	private static $instance = NULL;
	
	public static function get_instance(){
		if(self::$instance === null){
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}
	
	public function rander($page, $local_data = null) {
		$data['data'] = $local_data;
		include BASEPATH.'view/'.$page.'.php';
	}
}
?>