<?php
class Html {
	private static $instance = NULL;

	public static function get_instance(){
		if(self::$instance === null){
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}

	public function script($src) {
		$return = '';
		for ($i = 0; $i < count($src); $i++) {
			$return .= '<script type="text/javascript" src="'.WEBPATH.$src[$i].'.js"></script>';
		}
		return $return;
	}
	
	public function stylesheet($src) {
		$return = '';
		for ($i = 0; $i < count($src); $i++) {
			$return .= '<link rel="stylesheet" type="text/css" href="'.WEBPATH.$src[$i].'.css" />';
		}
		return $return;
	}
	
	public function title_meta($title, $keywords, $desc) {
		
	}
}
?>