<?php
	define('APPURL', 'http://www.21campus.cn/apps/esubject/');
	define('WEBPATH', '/');
	define('BASEPATH', '/usr/local/esubject'.WEBPATH);
	//$init['web_dir'] = '/';
	//$init["base_dir"] = '/usr/local/esubject'.$init["web_dir"];
	$DEBUG_MODE = 1;
	if (!isset($DEBUG_MODE)) $DEBUG_MODE=0;
	//$CACHE=1;
	require_once(BASEPATH."init_function.php");
?>
